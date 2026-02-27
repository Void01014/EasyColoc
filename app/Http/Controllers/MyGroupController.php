<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MyGroupController extends Controller
{
    public function view()
    {
        $user = auth()->user();
        $activeGroup = $user->groups()->where('status', true)->with('users')->first();
        $expenses = $activeGroup->expenses()->with('user')->get();
        Category::getCategories($activeGroup);
        
        return view('MyGroup', compact('user', 'activeGroup', 'expenses'));
    }
}
