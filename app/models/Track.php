<?php

class Track extends \Eloquent {
	protected $fillable = ['vinyl_id','artist_id','number','title','artist','duration'];

  public function vinyl(){
    return $this->belongsTo('Vinyl');
  }
}