<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'picture'
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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
			Transaction::create([
				"sender_id" => 0,
				"recipient_id" => $user->id,
				"title" => "Welcome to QuickPay",
				"description" => "Welcome to QuickPay. Here is 100 EUR to get you going.",
				"amount" => 100,
				"currency_id" => 2
			]);
        });
    }

    public function transactionsSender()
    {
        return $this->hasMany(Transaction::class, "sender_id");
    }

    public function transactionsRecipient()
    {
        return $this->hasMany(Transaction::class, "recipient_id");
    }

    public function requestsSender()
    {
        return $this->hasMany(Request::class, "sender_id");
    }

    public function requestsReceiver()
    {
        return $this->hasMany(Request::class, "receiver_id");
    }
}
