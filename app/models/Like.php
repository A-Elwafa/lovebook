<?php

class Like extends Eloquent {
    protected $table = 'likes';
    
    protected $fillable = ['user_id', 'post_id'];
    
    public function user(){
        return $this->belongsTo('User');
    }
}