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
        $tweets =$this->getTweets();
        return view('tweets', compact('tweets'));
    }
    public function getTweets()
    {
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
                    'count'=>'20'
                ]
            ]

        );
        $data = json_decode($res->getBody());
        echo $data[1]->id;
        dd($data);






    }
    // public function postTweets()
    // {
    // //   $this->data = $data
    // //
    // //   $tweet_id = isset($data['id_str']) ? $data['id_str'] : null;
    // //   $author = isset($data['user']['screen_name']) ? $data['user']['screen_name'] : null;
    // //   $replyTweet_id =isset($data['in_reply_to_status_id_str']) ? $data['in_reply_to_status_id_str'] : null;
    // //
    //     $client =$this->client;
    //     $res = $client->post();
    //
    //
    //     for ($i=0; $i < sizeof($data) ; $i++)
    //     {
    //       if (isset($data)) {
    //         [
    //         'id'=>$tweet_id,
    //         $author
    //       ]
    //         }
    //     }
    // }





}
