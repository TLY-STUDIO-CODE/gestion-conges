<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
