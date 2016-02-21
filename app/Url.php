<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Url extends Model
{
	use SoftDeletes;

  protected $dates = ['deleted_at'];
	protected $hidden = ['pivot', 'updated_at', 'deleted_at'];
	protected $fillable = array('title', 'url', 'description', 'list_id');

  public function tags()
  {
      return $this->belongsToMany('App\Tag', 'url_tags', 'url_id', 'tag_id');
  }
}
