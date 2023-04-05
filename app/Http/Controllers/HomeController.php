<?php

namespace App\Http\Controllers;

use App\Tweet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = 'C4ETech';
        $commonLinkUserNames = Tweet::select('id','searched_user', 'link_user_name', 'image')
        ->groupBy('link_user_name')
        ->havingRaw('COUNT(*) >= 2')
        ->get();

    dd($commonLinkUserNames);
        $response = file_get_contents('https://api.twitterpicker.com/user/timeline?username=' . $user);
        $response = json_decode($response);
        foreach ($response as $key => $value) {
            if ($value->in_reply_to_screen_name != null) {
                try {
                    $imgresponse = file_get_contents('https://api.twitterpicker.com/user/data?minimal=twittercircle&id=' . $value->in_reply_to_screen_name);
                    $imgdata = json_decode($imgresponse);
                    $tweet = new Tweet();
                    $tweet->searched_user = $user;
                    $tweet->link_user_name = $value->in_reply_to_screen_name;
                    $tweet->link_user_id = $value->in_reply_to_user_id;
                    $tweet->type = 'timeline';
                    $tweet->date_time = Carbon::parse($value->created_at);
                    $tweet->image = $imgdata->profile_image_url_https;
                    $tweet->save();
                } catch (\Throwable $th) {
                }
            }
        }
        $response = file_get_contents('https://api.twitterpicker.com/user/likes?username=' . $user);
        $response = json_decode($response);
        foreach ($response as $key => $value) {
            if ($value->in_reply_to_screen_name == $user) {
                $tweet = new Tweet();
                $tweet->searched_user = $user;
                $tweet->link_user_name = $value->user->screen_name;
                $tweet->link_user_id = $value->user->id;
                $tweet->type = 'likes';
                $tweet->date_time = Carbon::parse($value->created_at);
                $tweet->image = $value->user->profile_image_url_https;
                $tweet->save();
            }
        }
        return 'done';
    }
}
