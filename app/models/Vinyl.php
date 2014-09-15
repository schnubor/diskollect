<?php

class Vinyl extends \Eloquent {
	protected $fillable = ['user_id','artwork','artist','title','label','genre','price','videos','tracklist','country','size','count','color','type','catno','releasedate','releasetype','notes','weight'];

  public function user()
  {
    return $this->belongsTo('User');
  }

  public function tracks()
  {
      return $this->hasMany('Track');
  }

  /** Mixpanel events */

  public static function boot()
  {
    parent::boot();

    Vinyl::created(function($user)
    {
      $mixpanel = App::make('mixpanel');
      $mixpanel->track("Vinyl Created");
    }); 

    Vinyl::updated(function($user)
    {
      $mixpanel = App::make('mixpanel');
      $mixpanel->track("Vinyl Updated");
    });

    Vinyl::deleted(function($user)
    {
      $mixpanel = App::make('mixpanel');
      $mixpanel->track("Vinyl Deleted");
    });
  }

}
