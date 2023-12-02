<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Examination;
use App\Models\Gold;
use App\Models\Pawn;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PawnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $pawns = Pawn::get();


        // if($user->isSeller() || $user->isOwner()){
        //     $pawns = Pawn::get();
        // }
        // elseif($user->isCustomer()){
        //     $pawns = Pawn::where('customer_id', $user->national_id)->get();
        // }
        // else{
        //     return response()->json(['error' => 'Unauthenticated'], 401);
        // }

        return $pawns;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pawn = new Pawn();
        $pawn->customer_id = $request->get('customer_id');
        $pawn->examination_id = $request->get('examination_id');
        $pawn->contract_date = date('Y-m-d');
        $pawn->interest_rate = $request->get('interest_rate');
        $pawn->loan_amount = $request->get('loan_amount');
        $pawn->total_term = $request->get('total_term');
        $pawn->fine = 500;
        // $pawn->shop_payout_type = $request->get('shop_payout_type');
        // $pawn->customer_account = $request->get('customer_account');
        $pawn->paid_amount = 0;
        $pawn->paid_term = 0;
        $pawn->expiry_date = date('Y-m-d', strtotime('+' . $pawn->total_term . ' month'));
        $pawn->next_payment = date('Y-m-d', strtotime('+1 month'));

        $pawn->save();
        $pawn->refresh();

        $examination_id = $request->get('examination_id');

        $examination = Examination::where('id', $examination_id)->first();
        $golds = $examination->golds;

        foreach ($golds as $g) {
            if ($g->status === "verified") {
                $g->status = "pawned";
                $g->pawn_id = $pawn->id;

                $g->save();
                $g->refresh();
            }
        }

        $transaction = new Transaction();
        $transaction->customer_id = $request->get('customer_id');
        $user = auth()->user();
        $transaction->created_by = $user->national_id;
        $transaction->amount = $request->get('loan_amount');
        $transaction->type = "employeeWithdraw";
        $transaction->status = "inprogress";
        $transaction->pawn_id = $pawn->id;
        $transaction->save();
        $transaction->refresh();

        return $pawn;
    }

    /**
     * Display the specified resource.
     */
    public function show(Pawn $pawn)
    {
        $golds = $pawn->golds;
        $transactions = $pawn->transactions;
        return $pawn;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pawn $pawn)
    {
        $paidAmount = $request->input('paidAmount');
        $paidTerm = $request->input('paidTerm');
        $paid_select = $request->input('paidSelect');
        $pawnStatus = $request->input('pawnStatus');

        $pawn->paid_amount = $paidAmount;
        $pawn->paid_term = $paidTerm;
        $pawn->next_payment = date('Y-m-d', strtotime('+' . $paid_select . ' month')); //$nextPayment
        $pawn->status = $pawnStatus;
        $pawn->save();

        if($pawnStatus === "finish"){
            $golds = Gold::where("pawn_id", $pawn->id)->get();
            foreach ($golds as $g){
                $g->status = "redeemed";
                $g->save();
                $g->refresh();
            }
        }

        return response()->json(['message' => 'Transaction updated successfully']);
    }

    public function destroy(Pawn $pawn)
    {
        $id = $pawn->id;

        try {
            $pawn->delete();

        return [
            'message' => "Pawn ID {$id} has been deleted",
            'success' => true

        ];
    } catch (\Exception $e) {
        return response()->json([
            'status' => 500,
            'error' => $e->getMessage(),
        ], 500);
    }

}
    public function findPawnById($pawn_id)
    {
        $pawn = Pawn::where('id', $pawn_id)->first();
        $golds = $pawn->golds;
        $transactions = $pawn->transactions;

        if ($pawn != null){
            return $pawn;
        }
        else{
            return null;
        }
    }
}
