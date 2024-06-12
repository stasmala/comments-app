<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $fillable = [
        'username', 'email', 'homepage', 'captcha', 'parent_id', 'text'
    ];

    public function childrenRecursive(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('childrenRecursive');
    }
}
