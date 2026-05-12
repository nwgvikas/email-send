<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailTemplate extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'body',
    ];

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }
}
