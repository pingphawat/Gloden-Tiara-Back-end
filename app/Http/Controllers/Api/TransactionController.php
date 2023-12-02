<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pawn;
use App\Models\Transaction;
use DateTime;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $transactions = Transaction::get();

        return $transactions;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $transaction = new Transaction();
        $transaction->customer_id = $request->customer_id;
        $user = auth()->user();
        $transaction->created_by = $user->national_id;
        $transaction->amount = $request->amount;
        $transaction->type = "offlineInstallment";
        $transaction->status = "completed";
        $transaction->pawn_id = $request->pawn_id;
        $transaction->term = $request->term;
        $transaction->transaction_dateTime = date('Y-m-d');

        $transaction->save();
        $transaction->refresh();
    }

    /**
     * Display the specified resource.
     */
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            return $transaction;
        } else {
            return response()->json(['error' => 'ไม่พบข้อมูล Transaction'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $status = $request->input('status'); // รับค่าสถานะจาก request

        if ($transaction->status === 'inprogress') {
            // ตรวจสอบว่าสถานะเป็น 'inprogress' ก่อนที่จะอัปเดต
            if ($status === 'rejected') {
                $transaction->status = $status;
                $transaction->save();

                return response()->json(['message' => 'สถานะอัปเดตเรียบร้อย']);
            } else if ($status === 'completed' ) {
                $transaction->status = $status;
                $transaction->transaction_dateTime = date('Y-m-d');
                $transaction->save();
                $transaction->refresh();

                $pawn_id = $transaction->pawn_id;
                $pawn = Pawn::where("id", $pawn_id)->first();
                $pawn->shop_payout_status = "paid";
                $pawn->save();
                $pawn->refresh();

                return response()->json(['message' => 'สถานะอัปเดตเรียบร้อย']);
            } else {
                return response()->json(['error' => 'สถานะไม่ถูกต้อง'], 400);
            }
        } else {
            return response()->json(['error' => 'ไม่สามารถอัปเดตสถานะ เนื่องจากไม่ได้อยู่ในสถานะ inprogress'], 400);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json(['message' => 'Transaction ถูกลบเรียบร้อย']);
    }

    public function findTransactionByPawnId($pawn_id)
    {
        $transactions = Transaction::where('pawn_id', $pawn_id)
            ->whereIn('type', ['onlineInstallment', 'offlineInstallment'])
            ->get();

        return $transactions;
    }
}
