<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function manageUrl(Request $request)
    {
        return view('url.manage', []);
    }

    public function viewUrls()
    {
        $urls = Url::all();

        return view('url.view', ['urls' => $urls]);
    }
}
