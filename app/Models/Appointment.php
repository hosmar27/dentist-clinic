<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    public function patient() 
    { 
        return $this->belongsTo(Patient::class)->where('is_patient', true); 
    }

    public function dentist() 
    { 
        return $this->belongsTo(Dentist::class)->where('is_dentist', true); 
    }

    public function statu()
    { 
        return $this->belongsTo(Statu::class, 'status_id', 'id'); 
    }
}
