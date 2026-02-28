<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Payment;
use Illuminate\Http\Request;

class MyGroupController extends Controller
{
    public function view()
    {
        $user = auth()->user();

        $activeGroup = $user->groups()
            ->where('status', true)
            ->with('users.payments', function ($q) {
                $q->whereNULL('paid_at')
                    ->with('expense', function ($q) {
                        $q->select('id', 'user_id')
                            ->with('user:id,name');
                    });
            })
            ->first();

        $categories = Category::getCategories($activeGroup);

        $settlements = Payment::calcSettlments($activeGroup->users);

        return view('MyGroup', compact('user', 'activeGroup', 'categories', 'settlements'));
    }
}
