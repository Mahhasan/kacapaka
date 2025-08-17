<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_code',
        'phone',
        'joining_date',
        'is_active',
        'created_by'
    ];

    /**
     * Get the user that owns the employee profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who created this employee record.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
