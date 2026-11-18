<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Loans;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LoanDetails extends Model
{
    use LogsActivity;
    protected $fillable = ['loan_id','book_id','qty'];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loans::class, 'loan_id');
    }

    public function books(): BelongsTo
    {
        return $this->belongsTo(Books::class, 'book_id');
    }

    public function returnItems(): HasOne{
        return $this->hasOne(ReturnItems::class, 'loan_details_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty();
    }
    
}
