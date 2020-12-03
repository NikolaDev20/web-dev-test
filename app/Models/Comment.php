<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public function replies()
    {
        return $this->hasMany(CommentReply::class, 'comment_id');
    }
    protected $fillable  = ['email','content','name','post_id','news_id','approved'];
}
