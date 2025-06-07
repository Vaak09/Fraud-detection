<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scan;

class Customer extends Model
{
    protected $fillable = [ 
        'name',
        'customerId',
        'bsn',
        'firstName',
        'lastName',
        'dateOfBirth',
        'phoneNumber',
        'email',
        'tag',
        'street',
        'postcode',
        'city',
        'products',
        'ipAddress',
        'iban',
        'lastInvoiceDate',
        'lastLoginDateTime',
        'is_fraud',
        'fraud_reason',
        'scan_id', // Foreign key for Scan
    ];

    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }
}
