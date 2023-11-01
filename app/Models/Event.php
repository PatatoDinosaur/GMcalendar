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
        'title',
        'date',
        'time',
        ];
        
    protected $dates = ['date'];
    
    
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'event_post');
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }

}

?>