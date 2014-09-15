<?php

class Track extends \Eloquent {
	protected $fillable = ['vinyl_id','artist_id','number','title','artist','duration'];

  public function vinyl(){
    return $this->belongsTo('Vinyl');
  }

  /** Mixpanel events */

  public static function boot()
  {
    parent::boot();

    Track::created(function($user)
    {
      $mixpanel = App::make('mixpanel');
      $mixpanel->track("Track Created");
    }); 

    Track::updated(function($user)
    {
      $mixpanel = App::make('mixpanel');
      $mixpanel->track("Track Updated");
    });

    Track::deleted(function($user)
    {
      $mixpanel = App::make('mixpanel');
      $mixpanel->track("Track Deleted");
    });
  }
}