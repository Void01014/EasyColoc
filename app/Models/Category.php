<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public function group(){
        return $this->belongsTo(Group::class);
    }
    public static function getCategories($group){
        $group_cags = Category::doesntHave('group')->get();

        var_dump($group_cags);
        dd($group_cags);
        // return array_merge($cags, $group_cags);
    }
}
