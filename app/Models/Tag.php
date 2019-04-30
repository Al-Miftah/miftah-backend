<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    public function speeches()
    {
        return $this->belongsToMany(Speech::class);
    }
}
