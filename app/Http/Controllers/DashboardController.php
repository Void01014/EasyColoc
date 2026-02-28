<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function view(){
        $user = auth()->user();
        $activeGroup = $user->groups()->where('status', true)->with('users.payments')->first();
        $categories = Category::getCategories($activeGroup);

        return view('dashboard', compact('user', 'activeGroup', 'categories'));
    }
}
