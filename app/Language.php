<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;
    
    protected $fillable = [];
    
    public function speech()
    {
        return $this->hasMany(Speech::class);
    }
}
