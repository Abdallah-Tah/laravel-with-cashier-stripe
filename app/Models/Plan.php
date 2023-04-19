<?php

namespace App\Models;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'price',
        // 'description',
        'stripe_plan_id',
    ];
    

    /**
     * Get the features for the plan.
     */
    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }

    /**
     * Get the features for the plan.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
