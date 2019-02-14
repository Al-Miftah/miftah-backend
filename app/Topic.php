<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['title', 'slug'];

    protected $dates = ['deleted_at'];

    public function speeches()
    {
        return $this->hasMany(Speech::class);
    }
}
