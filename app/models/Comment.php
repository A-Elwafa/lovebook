<?php

class Comment extends Eloquent {
    protected $table = 'comments';
    
    protected $fillable = ['user_id', 'post_id', 'content'];
    
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
    
    public function post(){
        $this->belongsTo('Post');
    }
}
