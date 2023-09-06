<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Event extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    protected $fillable = [
        'comment',
        'date',
        'time',
        ];
    
    
    public function posts()
    {
        return $this->belongsToMany(User::class, 'event_post');
    }

}
