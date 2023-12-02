<?php

namespace Database\Seeders;

use App\Models\Pawn;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PawnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pawn::factory(15)->create();

        // $pawn = new Pawn();
        // $pawn->contract_id = '0123456789';
        // $pawn->customer_id = '1102200194355';
        // $pawn->examination_id = '9876543210';
        // $pawn->contract_date = today();
        // $pawn->expiry_date = today();
        // $pawn->interest_rate = 2.5;
        // $pawn->loan_amount = 10000;
        // $pawn->total_term = 12;
        // $pawn->fine = 1000;
        // $pawn->paid_amount = 5000;
        // $pawn->paid_term = 6;
        // $pawn->next_payment = today();
        // $pawn->status = 'unfinish';

        // $pawn = new Pawn();
        // $pawn->contract_id = '9876543210';
        // $pawn->customer_id = '553491002011';
        // $pawn->examination_id = '0123456789';
        // $pawn->contract_date = today();
        // $pawn->expiry_date = today();
        // $pawn->interest_rate = 2.5;
        // $pawn->loan_amount = 10000;
        // $pawn->total_term = 12;
        // $pawn->fine = 1000;
        // $pawn->paid_amount = 5000;
        // $pawn->paid_term = 6;
        // $pawn->next_payment = today();
        // $pawn->status = 'unfinish';
    }
}
