<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Zenapply\Shortener\Facades\Shortener;

class UrlController extends Controller
{
    public function manageUrl(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->has('url')) {
                $url = new Url();
                $url->original_url = $request->input('url');
                $url->shortened_url = Shortener::shorten($request->input('url'));
                $url->save();
                \Session::flash('message', 'Record saved');
            }

            return redirect('/view-urls');
        }

        return view('url.manage', []);
    }

    public function viewUrls()
    {
        $urls = Url::all();

        return view('url.view', [
            'urls' => $urls,
            'message' => \Session::get('message')
        ]);
    }
}
