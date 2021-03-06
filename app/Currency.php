<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function transaction()
    {
        return $this->belongsToMany(Transaction::class);
    }

    public function request()
    {
        return $this->belongsToMany(Request::class);
    }
}
