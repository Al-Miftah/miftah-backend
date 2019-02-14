<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function speech()
    {
        return $this->belongsTo(Speech::class);
    }
}
