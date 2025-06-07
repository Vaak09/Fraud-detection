<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = [
        'scan_date',
        'details', // Add this to store scan details
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}