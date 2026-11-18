<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Books extends Model
{
    use LogsActivity;
    protected $fillable = 
    ['title',
    'author',
    'isbn',
    'publisher',
    'publish_year',
    'image',
    'stock',
    'available_stock'];

    protected $casts = [
        'publish_year' => 'integer',
        'stock' => 'integer',
        'available_stock' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function loanDetails(): HasMany{
        return $this->hasMany(LoanDetails::class,'book_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty();
    }
}
