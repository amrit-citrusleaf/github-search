<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
/*
 * @author Amrit Rathi amrit@citrusleaf.in
 * Date 18-May-2018
 *
 * */
class SearchController extends Controller {

    public function index() {
        return view("index");
    }

    public function search(Request $request) {
        $client = new \GuzzleHttp\Client(['auth' => [config("app.github_email"), config("app.github_password")]]);
        $url = sprintf("https://api.github.com/users/%s/followers?page=%d", $request->username, $request->page);
        try {
            $response = $client->get($url);
            return $response->getBody()->getContents();
        }catch (ClientException $e) {
            return response("User not found", 400, []);
        }

    }

}
