<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Carbon\Carbon;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class LinkController extends Controller
{
    public function generateUrl()
    {
        $url = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 15);
        
        return $url;
    }

    public function findUrlInDatabase(string $url)
    {
        # code
    }

    public function redirectToUrl(string $url)
    {
        # code
    }

    // Check if url has protocol and www and if not, insert it
    public function checkLinkFormat(string $url)
    {

        $startUrl = '';
        if(strpos($url, 'http://www.') !== false || strpos($url, 'https://www.') !== false) {
            return $url;
        } else {
            if(substr($url, 0, 7) !== 'http://' || substr($url, 0, 8) !== 'https://') {
                $startUrl = 'http://';
            }

            if(strpos($url, 'www') === false) {
                if(substr($url, 0, 7) !== 'http://' && substr($url, 0, 8) !== 'https://') {
                    $startUrl = 'http://www.';
                } else {
                    if(substr($url, 0, 7) !== 'http://') {
                        return substr_replace($url, 'www.', strpos($url, 'http://') + 8, 0);
                    } else {
                        return substr_replace($url, 'www.', strpos($url, 'https://') + 9, 0);
                    }
                }
            }
            return trim($startUrl . $url);
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
        // if ($request->public == 'true') {
        //     $public = 1;
        // } else {
        //     $public = 0;
        // }

        Link::create([
            'user_id' => auth()->id(),
            'name_link' => $request->nameUrl,
            'shortened_link' => $this->generateUrl(),
            'recipient_link' => $this->checkLinkFormat($request->destinationUrl),
            'expired_at' => $expired,
            'public' => $public
            // 'deleted_at' => null //check this later
        ]);

        return redirect('user');
    }

    public function deleteUrl(Request $request) // do this now
    {
        Link::where('id', '=', $request->link_id)
        ->update(['deleted_at' => Carbon::now()]);
        return back();
    }
}
