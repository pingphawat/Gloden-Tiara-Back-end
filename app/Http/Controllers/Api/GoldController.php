<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Examination;
use App\Models\Gold;
use App\Models\Pawn;
use Illuminate\Http\Request;

class GoldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $golds = Gold::get();

        // if($user->isSeller() || $user->isOwner()){
        //     $golds = Gold::get();
        // }
        // elseif($user->isCustomer()){
        //     $golds = Gold::whereHas('examination', function ($query) use ($user) {
        //         $query->where('customer_id', $user->national_id);
        //     })->get();
        // }
        // else{
        //     return response()->json(['error' => 'Unauthenticated'], 401);
        // }

        return $golds;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $gold = new Gold();
        $gold->weight = $request->get('weight');
        $gold->purity = $request->get('purity');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/gold'), $imageName);
            $gold->image_path = $imageName;
        }

        $gold->examination_id = $request->get('examination_id');

        $gold->status = "examining";

        $gold->save();
        $gold->refresh();

        return $gold;
    }

    /**
     * Display the specified resource.
     */
    public function show(Gold $gold)
    {
        return $gold;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gold $gold)
    {
        $status = $request->input('status'); // รับค่าสถานะจาก request

        $examination_id = $gold->examination_id;

        if ($gold->status === 'examining') {
            // ตรวจสอบว่าสถานะเป็น 'inprogress' ก่อนที่จะอัปเดต
            if ($status === 'verified' || $status === 'unverified') {
                $gold->status = $status;
                $gold->save();

                $examination = Examination::where('id', $examination_id)->first();
                $golds = $examination->golds;

                $allVerified = true;
                foreach ($golds as $g) {
                    if ($g->status === "examining") {
                        $allVerified = false;
                        break;
                    }
                }

                if ($allVerified) {
                    $examination->status = "finish";
                    $examination->save();
                }

                return response()->json(['message' => 'สถานะอัปเดตเรียบร้อย']);
            } else {
                return response()->json(['error' => 'สถานะไม่ถูกต้อง'], 400);
            }
        } else {
            return response()->json(['error' => 'ไม่สามารถอัปเดตสถานะ เนื่องจากไม่ได้อยู่ในสถานะ examination'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gold $gold)
    {
        //
    }

    public function getGoldByUser()
    {
        $user = auth()->user();
        $examinations = $user->examinations;

        // Initialize an array to store the gold records
        $goldRecords = [];

        // Loop through the user's examinations and retrieve the gold records
        foreach ($examinations as $examination) {
            // Get the gold records for each examination
            $goldRecords = array_merge($goldRecords, $examination->golds->toArray());
        }

        return $goldRecords;
    }
}
