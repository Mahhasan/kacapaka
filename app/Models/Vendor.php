<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_name',   // Organization Name
        'person',     // Contact Person
        'phone',      // Phone Number
        'address',    // Address
        'remark',     // Comments or Remarks
        'status',     // Good or Bad
    ];

    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }
}
