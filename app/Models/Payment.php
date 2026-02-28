<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
            if ($member->id == Auth::id()) {
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

    public static function calcSettlments($members)
    {
        $settements = [];

        foreach ($members as $member) {
            foreach ($member->payments as $payment) {
                $from = $member->id;
                $to = $payment->expense->user->id;
                $amount = $payment->amount;

                if ($from === $to) continue;

                $key = "{$from}-to-{$to}";

                if (!isset($settements[$key])) {
                    $settements[$key] = [
                        'from' => $from,
                        'to' => $to,
                        'from_name' => $member->name,
                        'to_name' => $payment->expense->user->name,
                        'amount' => 0
                    ];
                }

                $settements[$key]['amount'] += $amount;
            }
        }

        $user_balances = [];
        $processedKeys = [];

        foreach ($settements as $key => $settement) {
            if (in_array($key, $processedKeys)) continue;

            $reverseKey = "{$settement['to']}-to-{$settement['from']}";
            $reverseAmount = $settements[$reverseKey]['amount'] ?? 0;

            $diff = $settement['amount'] - $reverseAmount;
            // dd($diff);

            if ($diff > 0) {
                $user_balances[] = [
                    'from' => $settement['from'],
                    'to' => $settement['to'],
                    'from_name' => $settement['from_name'],
                    'to_name' => $settement['to_name'],
                    'amount' => -$diff
                ];
                $user_balances[] = [
                    'from' => $settement['to'],
                    'to' => $settement['from'],
                    'from_name' => $settement['to_name'],
                    'to_name' => $settement['from_name'],
                    'amount' => +$diff
                ];
            } elseif ($diff < 0) {
                $user_balances[] = [
                    'from' => $settement['from'],
                    'to' => $settement['to'],
                    'from_name' => $settement['from_name'],
                    'to_name' => $settement['to_name'],
                    'amount' => abs($diff)
                ];
                $user_balances[] = [
                    'from' => $settement['to'],
                    'to' => $settement['from'],
                    'from_name' => $settement['to_name'],
                    'to_name' => $settement['from_name'],
                    'amount' => $diff
                ];
            }

            $processedKeys[] = $key;
            $processedKeys[] = $reverseKey;
        }

        // echo '<br>';
        // print_r($user_balances);
        // // print_r(collect($user_balances)->groupBy('from'));
        // dd('s');

        return collect($user_balances)->groupBy('from');
    }
}
