<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /** @use HasFactory<\Database\Factories\ExpenseFactory> */
    use HasFactory;

    public $fillable = ['user_id', 'group_id', 'name', 'description', 'category_id', 'amount'];

    public function user()
    {
        return parent::belongsTo(User::class);
    }
}
