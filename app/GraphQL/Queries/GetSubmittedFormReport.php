<?php

namespace App\GraphQL\Queries;

use App\Models\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

final class GetSubmittedFormReport
{
    public function __invoke($_, array $args): array
    {
        $form_id = collect(Arr::get($args, 'form_id', []));
        $user_id = collect(Arr::get($args, 'user_id', []))
            ->map(function ($next_user_id) {
                return $next_user_id['value'];
            })
            ->implode(",");

        $date_from = Arr::get($args, 'date_from', "");
        $date_to = Arr::get($args, 'date_to', "");
        $isFilteredByTemplate = Arr::get($args, 'isFilteredByTemplate', false);
        $isFilteredByContact = Arr::get($args, 'isFilteredByContact', false);
        $isFilteredByDateRange = Arr::get($args, 'isFilteredByDateRange', false);

        $getPivotedColumns = function ($items) {
            $sql = "";
            $items->each(function ($item) use (&$sql) {
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

        $report = [];
        $form_id->each(function ($next_form_id) use ($getPivotedColumns, &$report, $user_id, $isFilteredByContact, $isFilteredByDateRange, $date_from, $date_to) {

            $params[] = $next_form_id['value'];

            $sql = "SELECT\n";
            $sql .= "\tvfp.field_id\n";
            $sql .= "\t,vfp.component_id\n";
            $sql .= "\t,vfp.name\n";
            $sql .= "FROM vw_field_properties_pivot AS vfp\n";
            $sql .= "INNER JOIN fields AS fld ON (fld.id = vfp.field_id)\n";
            $sql .= "INNER JOIN forms AS f ON (f.id = fld.form_id)\n";
            $sql .= "WHERE (vfp.form_id = ?)\n";
            $sql .= "ORDER BY vfp.sort_order ASC;";
            $answer_fields = collect(DB::select($sql, [$next_form_id['value']]));

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
            $sql .= "WHERE (fillup_forms.form_id = ?)\n";
            if ($isFilteredByContact) {
                if ($user_id) {
                    $sql .= "\tAND (fillup_forms.user_id IN($user_id))\n";
                }
            }
            if ($isFilteredByDateRange) {
                $params[] = $date_from;
                $params[] = $date_to;
                $sql .= "\tAND (fillup_forms.created_at BETWEEN ? AND ?)\n";
            }
            $sql .= "GROUP BY fillup_form_fields.fillup_form_id\n";
            $sql .= "ORDER BY MAX(users.name) ASC;";

            $report[Str::slug($next_form_id['label'])] = collect(DB::select($sql, $params));
        });

        return $report;
    }
}
