<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Thujohn\Twitter\Facades\Twitter;
use File;
use Session;

class TweetController extends Controller
{

private $count=10;
private $format = 'array';

public function index(){

    $data = Twitter::getUserTimeline(['count'=>$this->count ,'format'=>$this->format]);
    //dd($data);

    return view('twitter')->with('data', $data);
  }

public function tweet(Request $request){

  $this->validate($request,[
    'tweet'=>'required'
  ]);

  //format the tweet into how it needs to be sent to twitter API
  $newTweet = ['status'=>$request->input('tweet')];

// Check if the image field is not empty

if(!empty($request->images)){
  //loop through the uploaded images array
  foreach ($request->images as $key => $value) {

    $uploadMedia = Twitter::uploadMedia(['media'=> File::get($value->getRealPath())]);
    if(!empty($uploadMedia)){
      $newTweet['media_ids'][$uploadMedia->media_id_string] = $uploadMedia->media_id_string;
    }
  }

}
$twitter = Twitter::postTweet($newTweet);
if($twitter ){
  Session::flash('success','message goes here');
}
return back();

}
}
