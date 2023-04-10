<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    use HasFactory;

    // ROLE specific ability.
    const SUPER_ADMIN_PRIVILEGE = "superadmin:privilege";
    const ADMIN_PRIVILEGE = "admin:privilege";
    const USER_PRIVILEGE = "user:privilege";
    const GUEST_PRIVILEGE = "guest:privilege";


    const CATEGORY_CAN_UPSERT = "category:can-upsert";
    const CATEGORY_CAN_DELETE = "category:can-delete";
    const CATEGORY_CAN_VIEW = "category:can-view";

    const COMMENT_CAN_UPSERT = "comment:can-upsert";
    const COMMENT_CAN_DELETE = "comment:can-delete";
    const COMMENT_CAN_VIEW = "comment:can-view";

    const POST_CAN_UPSERT = "post:can-upsert";
    const POST_CAN_DELETE = "post:can-delete";
    const POST_CAN_VIEW = "post:can-view";

    const ARTICLE_CAN_UPSERT = "article:can-upsert";
    const ARTICLE_CAN_DELETE = "article:can-delete";
    const ARTICLE_CAN_VIEW = "article:can-view";

    const NOTE_CAN_UPSERT = "note:can-upsert";
    const NOTE_CAN_DELETE = "note:can-delete";
    const NOTE_CAN_VIEW = "note:can-view";

    const HIGHLIGHT_CAN_UPSERT = "highlight:can-upsert";
    const HIGHLIGHT_CAN_DELETE = "highlight:can-delete";
    const HIGHLIGHT_CAN_VIEW = "highlight:can-view";

    const TAG_CAN_UPSERT = "tag:can-upsert";
    const TAG_CAN_DELETE = "tag:can-delete";
    const TAG_CAN_VIEW = "tag:can-view";



}