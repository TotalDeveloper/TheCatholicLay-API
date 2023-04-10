<?php

namespace Database\Seeders;

use App\Models\Ability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class abilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ability = new Ability();
        $ability->name = Ability::SUPER_ADMIN_PRIVILEGE;
        $ability->label = "Super admin";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::ADMIN_PRIVILEGE;
        $ability->label = "Admin";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::USER_PRIVILEGE;
        $ability->label = "User";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::GUEST_PRIVILEGE;
        $ability->label = "Guest";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::CATEGORY_CAN_UPSERT;
        $ability->label = "Can upsert Category records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::CATEGORY_CAN_DELETE;
        $ability->label = "Can delete Category records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::CATEGORY_CAN_VIEW;
        $ability->label = "Can view Category records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::COMMENT_CAN_UPSERT;
        $ability->label = "Can upsert Comment records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::COMMENT_CAN_DELETE;
        $ability->label = "Can delete Comment records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::COMMENT_CAN_VIEW;
        $ability->label = "Can view Comment records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::POST_CAN_UPSERT;
        $ability->label = "Can upsert POST records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::POST_CAN_DELETE;
        $ability->label = "Can delete POST records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::POST_CAN_VIEW;
        $ability->label = "Can view POST records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::ARTICLE_CAN_UPSERT;
        $ability->label = "Can upsert ARTICLE records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::ARTICLE_CAN_DELETE;
        $ability->label = "Can delete ARTICLE records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::ARTICLE_CAN_VIEW;
        $ability->label = "Can view ARTICLE records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::NOTE_CAN_UPSERT;
        $ability->label = "Can upsert NOTE records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::NOTE_CAN_DELETE;
        $ability->label = "Can delete NOTE records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::NOTE_CAN_VIEW;
        $ability->label = "Can view NOTE records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::NOTE_CAN_UPSERT;
        $ability->label = "Can upsert NOTE records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::NOTE_CAN_DELETE;
        $ability->label = "Can delete NOTE records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::NOTE_CAN_VIEW;
        $ability->label = "Can view NOTE records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::HIGHLIGHT_CAN_UPSERT;
        $ability->label = "Can upsert HIGHLIGHT fund records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::HIGHLIGHT_CAN_DELETE;
        $ability->label = "Can delete HIGHLIGHT fund records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::HIGHLIGHT_CAN_VIEW;
        $ability->label = "Can view HIGHLIGHT fund records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::TAG_CAN_UPSERT;
        $ability->label = "Can upsert TAG fund records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::TAG_CAN_DELETE;
        $ability->label = "Can delete TAG fund records";
        $ability->save();

        $ability = new Ability();
        $ability->name = Ability::TAG_CAN_VIEW;
        $ability->label = "Can view TAG fund records";
        $ability->save();


    }
}
