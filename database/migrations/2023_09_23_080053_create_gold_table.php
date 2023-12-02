<?php

use App\Models\Examination;
use App\Models\Pawn;
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
        Schema::create('gold', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Pawn::class, 'pawn_id')->nullable();
            $table->foreignIdFor(Examination::class, 'examination_id');
            $table->float('weight');
            $table->float('purity');
            $table->string('status')->default('examining'); //examining, verified, unverified, pawned, redeemed, unredeemed
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold');
    }
};
