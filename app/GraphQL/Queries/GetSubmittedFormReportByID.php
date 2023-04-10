<?php

namespace App\GraphQL\Queries;

use App\Models\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class GetSubmittedFormReportByID
{
    public function __invoke($_, array $args)
    {
        $fillup_form_id = Arr::get($args, 'fillup_form_id');
        $FILLUP_FORM_ID = $fillup_form_id;
        $getPivotedColumns = function ($items) {
            $sql = "";
            $items->each(function($item) use(&$sql) {
                $colName = Str::replace('"', '', $item->name);
                if (($item->component_id == \App\Models\Component::MULTI_SELECT) ||
                    ($item->component_id == \App\Models\Component::CHECKBOX) ||
                    ($item->component_id == \App\Models\Component::RADIO_BUTTONS) ||
                    ($item->component_id == \App\Models\Component::PROJECT)) {
                    $sql .= "\t,STRING_AGG(DISTINCT(CASE WHEN (fillup_form_fields.field_id = $item->field_id) THEN voc.description ELSE NULL END), CHR(10)) AS \"$colName\"\n";
                } else {
                    $sql .= "\t,REPLACE(MAX(CASE WHEN (fillup_form_fields.field_id = $item->field_id) THEN fillup_form_fields.answer ELSE '-' END), '\"', '') AS \"$colName\"\n";
                }
            });
            return $sql;
        };

        $sql = "SELECT\n";
        $sql .= "\tvfp.sort_order\n";
        $sql .= "\t,fld.component_id\n";
        $sql .= "\t,fff.field_id\n";
        $sql .= "\t,fff.id\n";
        $sql .= "\t,vfp.name\n";
        $sql .= "FROM fillup_form_fields AS fff\n";
        $sql .= "INNER JOIN fillup_forms AS f ON (f.id = fff.fillup_form_id)\n";
        $sql .= "INNER JOIN fields AS fld ON (fld.id = fff.field_id)\n";
        $sql .= "LEFT JOIN vw_field_properties_pivot AS vfp ON (vfp.field_id = fff.field_id)\n";
        $sql .= "WHERE (f.id = :id)\n";
        $sql .= "ORDER BY vfp.sort_order ASC;";
        $answer_fields = collect(DB::select($sql, [ "id" => $FILLUP_FORM_ID]));

        $sql = "SELECT\n";
        $sql .= "\tMAX(users.name) \"User-Name\"\n";
        $sql .= "\t,MAX(forms.name) \"Form-Name\"\n";
        $sql .= $getPivotedColumns($answer_fields);
        $sql .= "FROM fillup_form_fields\n";
        $sql .= "INNER JOIN fillup_forms ON (fillup_forms.id = fillup_form_fields.fillup_form_id)\n";
        $sql .= "INNER JOIN users ON (fillup_forms.user_id = users.id)\n";
        $sql .= "INNER JOIN forms ON (forms.id = fillup_forms.form_id)\n";
        $sql .= "LEFT JOIN vw_field_property_option_answers AS voa ON (voa.fillup_form_field_id = fillup_form_fields.id)\n";
        $sql .= "LEFT JOIN vw_field_property_option_choices AS voc ON (voc.uuid = voa.answer)\n";
        $sql .= "WHERE (fillup_form_fields.fillup_form_id = ?)\n";
        $sql .= "GROUP BY fillup_form_fields.fillup_form_id";
        return DB::select($sql, [$FILLUP_FORM_ID]);
    }
}
