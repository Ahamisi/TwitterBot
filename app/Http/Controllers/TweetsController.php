<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TweetsController extends Controller
{
  public $id, $replyToUser, $replyToId;
    public function index()
    {
        $tweetData =$this->getTweets();
        return view('tweets', compact('tweetData'));
    }
    public function getTweets()
    {
      $sinceId = 1;


  //This will store the ID of the last tweet we get

      $maxId= $sinceId;

      //creates a middleware for authenticating requests
        $stack = HandlerStack::create();

        $middleware = new Oauth1(
            [
            'consumer_key'    => config('services.twitter.consumer_key'),
            'consumer_secret' => config('services.twitter.consumer_secret'),
            'token'           => config('services.twitter.access_token'),
            'token_secret'    => config('services.twitter.access_token_secret'),
            ]
        );

        $stack->push($middleware);

        $client = new Client(
            [
            'base_uri' => 'https://api.twitter.com/1.1/',
            'handler' => $stack,
            'auth' => 'oauth',
            ]
        );

          // Set the "auth" request option to "oauth" to sign using oauth
        $res = $client->get(
            'statuses/mentions_timeline.json',
            [
                'query'=> [
                    'count'=>'20',
                    'since_id'=>  $sinceId
                ]
            ]

        );

        $tweets = [];
        $data = json_decode($res->getBody());

        foreach ($data as $index => $mentions) {
          // code...
           $tweets[] = [
             'id' => $data['id'],
             'user_id' => $data['user']['id_str'],
             'username' => $data['user']['screen_name'],
           ]
        }
        dd($data);
        // if ($search->search_metadata->max_id_str > $max_id){
        //         $maxId = $search->->max_id_str;
        // }







    }
    // public function postTweets()
    // {
    //   $data = $this->data;
    //
    //   foreach ($data as $tweet) {
    //     // code...
    //     $res = $client->post('/statuses/update',
    //     [
    //       'status' => '@'.$tweet->from_user.' '.$reply,
		// 		  'in_reply_to_status_id' => $tweet->id_str
    //     ])
    //   }
    //
    // }





}
