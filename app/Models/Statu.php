<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statu extends Model
{
    use HasFactory;

    protected $table = 'status';
    
    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}
