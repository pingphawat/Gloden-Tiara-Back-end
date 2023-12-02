<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gold extends Model
{
    use HasFactory;

    public function examination(): BelongsTo {
        return $this->belongsTo(Examination::class);
    }

    public function pawn(): BelongsTo {
        return $this->belongsTo(Pawn::class);
    }
}
