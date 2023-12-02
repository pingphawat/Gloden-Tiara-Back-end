<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Examination;
use Illuminate\Http\Request;
use PhpParser\Node\Expr;

class ExaminationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $examinations = Examination::get();

        // if($user->isSeller() || $user->isOwner()){
        //     $examinations = Examination::get();
        // }
        // elseif($user->isCustomer()){
        //     $examinations = Examination::where('customer_id', $user->national_id)->get();
        // }
        // else{
        //     return response()->json(['error' => 'Unauthenticated'], 401);
        // }

        return $examinations;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $examination = new Examination();
        $examination->customer_id = $request->get('customer_id');
        $examination->contract_date = date('Y-m-d');

        $examination->save();
        $examination->refresh();

        return $examination;
    }

    /**
     * Display the specified resource.
     */
    public function show(Examination $examination)
    {
        $golds = $examination->golds;
        return $examination;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Examination $examination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Examination $examination)
    {
        //
    }

    public function findExaminationById($examinationId)
    {
        $examination = Examination::where('id', $examinationId)->first();
        $golds = $examination->golds;

        if ($examination != null){
            return $examination;
        }
        else{
            return null;
        }
    }
}
