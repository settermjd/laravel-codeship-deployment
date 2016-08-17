<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Zenapply\Shortener\Shortener;

/**
 * Class UrlController
 * @package App\Http\Controllers
 */
class UrlController extends Controller
{
    /**
     * Manage URLs
     *
     * This includes simply rendering the form for adding them, or going through the
     * process of actually adding them.
     *
     * @param Request   $request
     * @param Store     $session
     * @param Shortener $shortener
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageUrl(Request $request, Store $session, Shortener $shortener)
    {
        if ($request->isMethod('post')) {
            if ($request->has('url')) {
                $this->validate($request, [
                    'url' => 'required|url|unique:urls,original_url',
                ]);

                $this->saveAndFlash($request, $session, $shortener);
            }
        }

        return view('url.manage', []);
    }

    /**
     * View all stored URLs
     *
     * @param Store $session
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewUrls(Store $session)
    {
        $urls = Url::all();

        return view('url.view', [
            'urls'    => $urls,
            'message' => $session->get('message'),
        ]);
    }

    /**
     * Persist the Url/Route object
     *
     * @param Request   $request
     * @param Shortener $shortener
     *
     * @return bool
     */
    private function save(Request $request, Shortener $shortener)
    {
        $url = new Url();
        $url->original_url = $request->input('url');
        $url->shortened_url = $shortener->shorten($request->input('url'));

        return $url->saveOrFail();
    }

    /**
     * Attempt to persist the record and store an appropriate flash message
     *
     * @param Request   $request
     * @param Store     $session
     * @param Shortener $shortener
     */
    private function saveAndFlash(Request $request, Store $session, Shortener $shortener)
    {
        $message = $this->save($request, $shortener) ? 'Record saved' : 'Record NOT saved';
        $session->flash('message', $message);
    }
}
