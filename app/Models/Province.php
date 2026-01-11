<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
