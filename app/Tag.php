<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
		protected $hidden = ['pivot'];
    public function urls()
    {
        return $this->belongsToMany('App\Url', 'url_tags', 'tag_id', 'url_id');
    }
}
