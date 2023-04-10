<?php

namespace Database\Seeders;

use App\Models\Ability;
use Illuminate\Database\Seeder;
use Str;
use App\Models\Role;

class rolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //
        // SUPER ADMIN
        //
        $roleSuperAdmin = new Role();
        $roleSuperAdmin->id = Role::SUPER_ADMIN;
        $roleSuperAdmin->uuid = Str::uuid();
        $roleSuperAdmin->name = 'super administrator';
        $roleSuperAdmin->description = 'Super Administrator';
        $roleSuperAdmin->save();
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::SUPER_ADMIN_PRIVILEGE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::CATEGORY_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::CATEGORY_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::CATEGORY_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::ARTICLE_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::ARTICLE_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::ARTICLE_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::COMMENT_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::COMMENT_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::COMMENT_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::POST_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::POST_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::POST_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::NOTE_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::NOTE_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::NOTE_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::HIGHLIGHT_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::HIGHLIGHT_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::HIGHLIGHT_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::TAG_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::TAG_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::TAG_CAN_VIEW)->pluck('id'));

        //
        // ADMIN
        //
        $roleAdmin = new Role();
        $roleAdmin->id = Role::ADMIN;
        $roleAdmin->uuid = Str::uuid();
        $roleAdmin->name = 'administrator';
        $roleAdmin->description = 'Administrator';
        $roleAdmin->save();
        $roleAdmin->abilities()->attach(Ability::where('name', Ability::ADMIN_PRIVILEGE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::ARTICLE_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::ARTICLE_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::ARTICLE_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::COMMENT_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::COMMENT_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::COMMENT_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::POST_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::POST_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::POST_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::NOTE_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::NOTE_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::NOTE_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::HIGHLIGHT_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::HIGHLIGHT_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::HIGHLIGHT_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::TAG_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::TAG_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::TAG_CAN_VIEW)->pluck('id'));

        //
        // USER
        //
        $roleEmployee = new Role();
        $roleEmployee->id = Role::USER;
        $roleEmployee->uuid = Str::uuid();
        $roleEmployee->name = 'user';
        $roleEmployee->description = 'User';
        $roleEmployee->save();
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::COMMENT_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::COMMENT_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::COMMENT_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::POST_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::POST_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::POST_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::NOTE_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::NOTE_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::NOTE_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::HIGHLIGHT_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::HIGHLIGHT_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::HIGHLIGHT_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::TAG_CAN_UPSERT)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::TAG_CAN_DELETE)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::TAG_CAN_VIEW)->pluck('id'));

        //
        // GUEST
        //
        $roleEmployee = new Role();
        $roleEmployee->id = Role::GUEST;
        $roleEmployee->uuid = Str::uuid();
        $roleEmployee->name = 'user';
        $roleEmployee->description = 'User';
        $roleEmployee->save();
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::COMMENT_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::POST_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::NOTE_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::HIGHLIGHT_CAN_VIEW)->pluck('id'));
        $roleSuperAdmin->abilities()->attach(Ability::where('name', Ability::TAG_CAN_VIEW)->pluck('id'));
    }
}