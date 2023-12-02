<?php

use App\Models\Pawn;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'customer_id');
            $table->foreignIdFor(User::class, 'created_by');
            $table->float('amount');
            $table->string('type'); //onlineInstallment, offlineInstallment, employeeWithdraw
            $table->string('status'); //inprogress, completed, rejected
            $table->foreignIdFor(Pawn::class, 'pawn_id');
            $table->integer('term')->nullable();
            $table->dateTime('transaction_dateTime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
