<?php

namespace App;

use App\Http\Requests\RealStateRequest;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    public function realStates()
    {
        return $this->belongsToMany(RealState::class, 'real_state_categories');
    }
}
