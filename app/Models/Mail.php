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
        'subject',
        'body',
    ];

    public function addressees()
    {
        return $this->hasMany(Addressee::class,'mail_id');
    }

    public function mailAddress()
    {
        return $this->belongsToMany(Mail::class, 'addressees_mails', 'mail_id', 'addressee_id');
    }
}
