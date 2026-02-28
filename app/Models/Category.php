<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public static function getCategories($group)
    {
        return Category::whereNull('group_id')
            ->orWhere('group_id', $group?->id)
            ->get();
    }
}
