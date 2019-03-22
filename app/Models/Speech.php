<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speech extends Model
{
    use SoftDeletes;
    
    protected $fillable = [];
    
    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
