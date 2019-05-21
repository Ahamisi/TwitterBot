<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TweetsController extends Controller
{
    public $reply= 'you mentioned me, beautiful day it is today. Do have a great day!';
    protected $client;

    public function index()
    {
        $tweetData =$this->getTweets();
        $result = $this->postTweets($tweetData);
        print_r($result);
        return view('tweets', compact('tweetData'));
    }


    function __construct(){
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

        $this->client = new Client(
            [
            'base_uri' => 'https://api.twitter.com/1.1/',
            'handler' => $stack,
            'auth' => 'oauth',
            ]
        );
    }

    public function getTweets()
    {

      $sinceId = 1;

          // Set the "auth" request option to "oauth" to sign using oauth
        $res = $this->client->get(
            'statuses/mentions_timeline.json',
            [
                'query'=> [
                    'count'=>'20',
                    'since_id'=>  $sinceId //retrieves tweets since this particular id
                ]
            ]

        );

        $data = json_decode($res->getBody());

        //get the number of tweets returned, reduce it by 1 and set it as the new sinceId

        $tweetcount = sizeof($data);
        $sinceId = $data[$tweetcount - 1]->id;


        $tweets = [];
        foreach ($data as $index => $mentions) {

          // pushes the data retrieved into an array

          array_push($tweets,[
            'id' => !empty($mentions->id) ? $mentions->id : '',
            'username' => !empty($mentions->user) ? $mentions->user->screen_name : ''
          ]);
        };
        return $tweets;
    }


    public function postTweets($data)
    {
      foreach ($data as $tweet) {
        // code...
        $res = $this->client->post('statuses/update.json',[
          'query' => [
            'status' => '@'.$tweet['username'].' Hi there, '.$this->reply,
  				  'in_reply_to_status_id' => $tweet['id'],
          ]
        ]);
      };

      $data = json_decode($res->getBody());
    }




}
