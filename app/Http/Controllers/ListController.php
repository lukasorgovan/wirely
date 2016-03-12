<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function index() {

    	$lists = DB::select('select * from lists');    	
    	return $lists;
    }

    public function destroy($uuid) {
    	$numRowsDeleted = DB::table('lists')->where('uuid', $uuid)->delete();
    	$success = $numRowsDeleted > 0 ? true : false;
        
        if ($success) {
    	   return response('', 204);
        } 
    
        return response('', 400);
    }

    public function update(Request $request, $uuid) {
    	$data = $request->all();
    	$success = false;

    	if ($data["title"] != '') {
	    	$numRowsUpdtated = DB::table('lists')->where('uuid', $uuid)->update(['title' => $data["title"]]);
	    	$success = $numRowsUpdtated > 0 ? true : false;
	    }

        if ($success) {
    	   return response('',204);
        }
    
       return response('', 400);
    }

    public function store(Request $request) {
    	$listTitle = $request->input('title');

    	if ($listTitle != '') {
    		$storedUuids = DB::table('lists')->select('uuid')->get();
    		// Generate a random uuid string
	    	do {
	    		$uniqueId = substr(strtoupper(md5(uniqid(rand(),true))),0,8);
	    	} while (in_array($uniqueId, $storedUuids) == true);
	    	
	    	$success = DB::table('lists')->insert(
	    			['uuid' => $uniqueId, 'title' => $listTitle]
	    	);
	    	

    		if ($success) {
	    		return response()->json(array(
	    			'uuid' => $uniqueId
	    		), 201);
	    	}
    	}
    	
    	return response('', 400);
    }
    
}
