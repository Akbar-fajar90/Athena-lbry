<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Loans;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Returns extends Model
{
    use LogsActivity;
    protected $fillable = ['loan_id','received_by','return_date', 'status', 'fine'];
    
    protected $casts = [
        'return_date'=>'date'
        ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loans::class, 'loan_detail_id');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function returnItems(): HasMany{
        return $this->hasMany(ReturnItems::class,'return_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty();
    }
}
