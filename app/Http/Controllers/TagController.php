<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;

class TagController extends Controller
{

    public function index() {

    	//$tags = DB::select('select * from tags');
        $tags = Tag::all();
    	return $tags;
    }

    public function store(Request $request) {
    	$tagTitle = $request->input('title');

    	if ($tagTitle != '') {
    		try {
		    	$id = DB::table('tags')->insertGetId(
		    			['title' => $tagTitle]
		    	);
		    	return response()->json(array(
    				'id' => $id
    			), 201);

	      } catch (\Exception $e) {
	      	// no need to handle
	      }
    	}
    	
    	return response('', 400);
    }

}
