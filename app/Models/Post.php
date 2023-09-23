<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    protected $fillable = [
        'title',
        'body',
        'category_id',
        'access_type'
        ];

    public function getPaginateByLimit(int $limit_count = 5)
    {
        //updated_atで降順に並べた後、limitで件数制限をかける
        return $this::with('category')->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'post_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_post');
    }
}

?>