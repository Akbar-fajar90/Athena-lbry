<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use app\Models\Books;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Loans extends Model
{
    use LogsActivity;
    protected $fillable = ['procced_by','loan_date', 'due_date', 'status', 'note'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function procced():BelongsTo
    {
        return $this->belongsTo(User::class, 'procced_by');
    }

    public function loanDetails():HasMany
    {
        return $this->hasMany(LoanDetails::class,'loan_id');
    }

    public function return(): HasOne
    {
        return $this->hasOne(Returns::class, 'loan_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty();
    }


    
}
