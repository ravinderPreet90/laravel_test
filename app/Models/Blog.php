<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table='blogs';
    public function blog_like(){
        return $this->hasMany(Blog_like::class,  'blog_id','id');
    }
    public function blog_comment(){
        return $this->hasMany(Blog_comment::class,  'blog_id','id');
    }
    

}
