<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function recipient()
    {
        return $this->belongsToMany(Transaction::class);
    }
}
