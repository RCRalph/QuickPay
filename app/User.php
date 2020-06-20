<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transactionsSender()
    {
        return $this->hasMany(Transaction::class, "sender_id")->latest();
    }

    public function transactionsRecipient()
    {
        return $this->hasMany(Transaction::class, "recipient_id")->latest();
    }

    public function requestsSender()
    {
        return $this->hasMany(Request::class, "sender_id");
    }

    public function requestsReciever()
    {
        return $this->hasMany(Request::class, "reciever_id");
    }
}
