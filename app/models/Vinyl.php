<?php

class Vinyl extends \Eloquent {
	protected $fillable = ['user_id','artwork','artist','title','label','genre','price','videos','tracklist','country','size','count','color','type','catno','releasedate','releasetype','notes','weight'];

  public function user()
  {
    return $this->belongsTo('User');
  }

}
