<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Categories extends Model
{
    use LogsActivity;
    protected $fillable = ['name',
    'deskripsi'];

    public function Books(): HasMany
    {
        return $this->hasMany(Books::class,'book_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty();
    }
}
