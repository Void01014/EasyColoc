<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $fillable = ['user_id', 'expense_id', 'amount', 'paid_at'];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public static function makePayments($members, $expense)
    {
        $totalMembers = count($members); 
        $payments = [];

        foreach ($members as $member) {
            if ($member->pivot->role == "owner") {
                $payments[] = [
                    'user_id' => $member->id,
                    'expense_id' => $expense->id,
                    'amount' => $totalMembers ? round($expense->amount / count($members), 2) : 0,
                    'paid_at' => now(),
                ];
            } else {
                $payments[] = [
                    'user_id' => $member->id,
                    'expense_id' => $expense->id,
                    'amount' => $totalMembers ? round($expense->amount / count($members), 2) : 0,
                    'paid_at' => null,
                ];
            }
        }

        Payment::insert($payments);
    }
}
