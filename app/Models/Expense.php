<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    // Mass-assignment whitelist — only these fields can be set via create()/update()
    protected $fillable = [
        'date',
        'cost',
        'description',
        'expense_type',
    ];

    // Automatic type casting when reading from DB
    protected $casts = [
        'date' => 'date',
        'cost' => 'decimal:2',
    ];
}