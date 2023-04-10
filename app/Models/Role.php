<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    const SUPER_ADMIN = 100;
    const ADMIN = 101;
    const USER = 102;
    const GUEST = 103;


    protected $fillable = [
        'id',
        'name',
        'code',
        'slug'
    ];
    
    /**
     * The abilities that belong to the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(Ability::class);
    }
}
