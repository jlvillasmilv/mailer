<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addressee extends Model
{
    use HasFactory;

    protected $table = 'addressees';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
        'user_id',
    ];


    public function mailAddress()
    {
        return $this->belongsToMany(Mail::class, 'addressees_mails', 'addressee_id', 'mail_id');
    }
}
