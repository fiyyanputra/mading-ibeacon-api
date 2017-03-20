<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use App\Model\Post;
use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get_infos/{uuid}', function($uuid){
    $posts = DB::table('posts')->where('beacon_uuid', '=', $uuid)->get();
	$beacon = DB::table('beacons')->where('UUID', '=', $uuid)->first();
    return response()->json([
        'status' => true,
		'beacon' => $beacon,
        'posts' => $posts
    ]);
});

Route::get('/get_image/{filename}', function($filename){
    $file = "ftp://ftppptik.lskk.ee.itb.ac.id|ftppptik:XxYyZz123!@ftppptik.lskk.ee.itb.ac.id/mading/".$filename;	
	return response(file_get_contents($file))->header('Content-Type', 'image/jpg');
});

Route::post('/new_info', function(Request $request){
	$post = new Post();
	$post->user_id = $request->input('user_id');
	$post->beacon_id = $request->input('beacon_id');
	$post->beacon_uuid = $request->input('beacon_uuid');
	$post->title = $request->input('title');
	$post->body = $request->input('body');
	$post->category = $request->input('category');
	$post->image = $request->input('image');
	$post->status = '1';
	$post->created_at   = Carbon::now();
    $post->save();
	
	return response()->json([
            'success'    => true,
            'msg'        => 'success',
			'post' 	 => $post
        ]);
	
});
