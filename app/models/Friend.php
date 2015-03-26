<?php

class Friend extends Eloquent {
    
    protected $fillable = ['user1_id', 'user2_id', 'accepted'];

    protected $table = 'friends';
}