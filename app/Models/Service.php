<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'lname',
        'phone',
        'email',
        'scam_type',
        'transaction_type',
        'scam_amount',
        'scam_description',
    ];
}
