<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'department_id',
        'hire_date',
        'leave_balance',
    ];

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
