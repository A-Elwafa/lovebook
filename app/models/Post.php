<?php

class Post extends Eloquent {
    protected $table = 'posts';
    protected $fillable = ['user_id', 'content'];
    protected $primaryKey = 'id';
    
    public function getDateAttribute()
    {
            if(!isset($this->created_at)) return '';
            return date('d.m.Y', strtotime($this->created_at));
    }
    
    public function getTimeAttribute()
    {
            if(!isset($this->created_at)) return '';
            return date('H:i', strtotime($this->created_at));
    }
    public function user(){
        return $this->belongsTo('User');
    }
    
    public function comments(){
        return $this->hasMany('Comment', 'post_id');
    }
    
    public function likes(){
        return $this->hasMany('Like', 'post_id');
    }
    
    public function usersThatLiked(){
        return;
    }
}