<?php

class Profile extends Eloquent {
    protected $table = 'profiles';
    protected $fillable = ['location', 'school', 'gender', 'dob', 'about_me', 
        'profPic_name', 'profPic_path', 'profPic_name_thumb', 'profPic_path_thumb', 
        'profPic_name_mini_thumb', 'profPic_path_mini_thumb'];
    
    protected $primaryKey = 'user_id';
    
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
    
    // for edit profile page, return DOB in HTML5 value format for date type input
    public function getDobForEditAttribute(){
            return date('Y-m-d', strtotime($this->dob));
    }
    public function getDobForProfileAttribute()
    {
            if(!isset($this->dob)) return '';
            return date('d.m.Y', strtotime($this->dob));
    }
    
    public function getProfilePicAttribute(){
        return  $this->profPic_path . $this->profPic_name;
    }
    public function getProfilePicThumbAttribute(){
        return  $this->profPic_path_thumb . $this->profPic_name_thumb;
    }
    
    public function getProfilePicMiniThumbAttribute(){
        return $this->profPic_path_mini_thumb . $this->profPic_name_mini_thumb;
    }
}