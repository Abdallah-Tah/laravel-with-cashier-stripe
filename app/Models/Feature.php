<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'max_amount',
    ];

    public function plans()
    {
        return $this->belongsToMany(Plan::class);
    }
}
