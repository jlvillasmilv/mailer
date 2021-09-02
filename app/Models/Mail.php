<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'contract_status',
        'disbursement_status',
        'observation',
        'description'
    ];

    public function addressees()
    {
        return $this->hasMany(Addressee::class,'mail_id');
    }
}
