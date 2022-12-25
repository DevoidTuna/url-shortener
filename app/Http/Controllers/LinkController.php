<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function generateUrl()
    {   
        $url = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 15);
        while ($this->findUrlInDatabase($url)) {
            $url = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 15);
        }
        return $url;
    }

    public function findUrlInDatabase(string $url)
    {
        return Link::where('shortened_link', '=', $url)->first();
    }

    public function notFound()
    {
        return view('notFound', ['errorMessage' => 'Page not found.']);
    }

    public function redirectUrl(string $url)
    {
        $shortUrl = Link::where('shortened_link', '=', $url)
                        ->where(function ($query) {
                                $query->where('expired_at', '>=', Carbon::now())
                                    ->orWhere('expired_at', '=', null);
                                })
                        ->where('deleted_at', '=', null)
                        ->first('recipient_link');


        if(empty($shortUrl)) return view('notFound', ['errorMessage' => 'URL deleted or expired.']);

        return redirect($shortUrl->recipient_link);
    }

    // Check if url has protocol and www and if not, insert it
    public function checkLinkFormat(string $url)
    {
        if(strpos($url, 'http://') !== false || strpos($url, 'https://') !== false) {
            return $url;
        } else {
            return 'http://' . $url; 
        }
    }
    
    public function store(Request $request)
    {
        // Save the time that will be available
        $expired = '';
        if ($request->expiration < 0) {
            $expired = null;
        } else {
            $expired = Carbon::now()->addMinutes($request->expiration);
        }

        // Check if the shortened url will be public
        $public = '';
        $request->public == 'true' ? $public = 1 : $public = 0;

        Link::create([
            'user_id' => auth()->id(),
            'name_link' => $request->nameUrl,
            'shortened_link' => $this->generateUrl(),
            'recipient_link' => $this->checkLinkFormat($request->destinationUrl),
            'expired_at' => $expired,
            'public' => $public
        ]);

        return redirect('user');
    }

    public function deleteUrl(Request $request)
    {
        Link::where('id', '=', $request->link_id)->delete();
        return back();
    }
}
