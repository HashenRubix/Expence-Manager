<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();                                   // auto-increment primary key
            $table->date('date');                           // expense date
            $table->decimal('cost', 10, 2);                 // cost in rupees, 2 decimal places
            $table->string('description');                  // free text
            $table->enum('expense_type', ['travel', 'food', 'other']); // constrained to 3 values
            $table->timestamps();                           // created_at / updated_at, free with Eloquent
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};