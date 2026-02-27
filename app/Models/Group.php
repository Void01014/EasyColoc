<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /** @use HasFactory<\Database\Factories\GroupFactory> */
    use HasFactory;

    public $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function addUser($role){
        auth()->user()->groups()->attach($this->id, [
            'role' => $role
        ]);
    }
}
