<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TweetsController extends Controller
{
    public function index()
    {
        $this->getTweets();
    }
    public function getTweets()
    {
        $stack = HandlerStack::create();

        $middleware = new Oauth1(
            [
            'consumer_key'    => config('services.twitter.consumer_key'),
            'consumer_secret' => config('services.twitter.consumer_key'),
            'token'           => config('services.twitter.consumer_key'),
            'token_secret'    => config('services.twitter.consumer_key'),
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
        $res = $client->get('statuses/mentions_timeline.json');
    }





}
