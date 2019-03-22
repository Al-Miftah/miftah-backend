<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speaker extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'phone', 'email', 'bio', 'address', 'avatar'];
    
    public function speeches()
    {
        return $this->hasMany(Speech::class);
    }
}
