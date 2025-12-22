<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo(PackageCategory::class);
    }

    public function inquiries()
    {
        return $this->hasMany(PackageInquiry::class);
    }
}
