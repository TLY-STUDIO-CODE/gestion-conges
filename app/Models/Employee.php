<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
   public function leaveRequests()
   {
        return $this->hasMany(LeaveRequest::class);

    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
