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

  public function store(Request $request, $listId) {
		$data = $request->all();
		$data["list_id"] = $listId;
		$tags = $data["tags"];
		$newTags = array();

		unset($data["tags"]);
		

		$success = DB::beginTransaction();

		try {
			$url = new Url;
			$url->fill($data);
			$url->save();

			$i = 0;
			foreach ($tags as $tag) {
				array_push($newTags, array("tag_id" => $tag, "url_id" => $url->id));
				$i++;
			}

			DB::table('url_tags')->insert($newTags);
			DB::commit();


			return response()->json(array(
				'id' => $url->id
			), 201);
	
		} catch (\Exception $e) {
    	DB::rollback();

	  	return response('', 400);	
    }
  }

  public function destroy($listId, $urlId) {

		$success = Url::where('id', $urlId)->delete();
		
	 if ($success) {
	   return response('', 204);
  	}

    return response('', 400);
  }
}
