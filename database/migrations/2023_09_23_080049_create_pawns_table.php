<?php

use App\Models\Examination;
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
        Schema::create('pawns', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'customer_id');
            $table->foreignIdFor(Examination::class, 'examination_id');
            $table->date('contract_date');
            $table->date('expiry_date');
            $table->float('interest_rate');
            $table->float('loan_amount');
            $table->integer('total_term');
            $table->float('fine');
            $table->string('shop_payout_status')->default('pending'); //pending, paid
            // $table->string('shop_payout_type'); //cash, transaction
            // $table->string('customer_account')->nullable();
            $table->float('paid_amount');
            $table->integer('paid_term');
            $table->date('next_payment');
            $table->string('status')->default('active'); //active, finish
            $table->binary('pdf_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pawns');
    }
};
