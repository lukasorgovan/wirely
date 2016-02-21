<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Tag;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Url;

class UrlController extends Controller
{
	public function index($listId) {

		$urls = Url::with('tags')->where('list_id', $listId)->get();	
		return $urls;
  }

  public function destroy($listId, $urlId) {

		$success = Url::where('id', $urlId)->delete();
		
		if ($success) {
			return response()->json(array(
	    		'success' => true
	   	));
	  }

	  return response()->json(array(
  		'success' => false
   	));
  }
}
