<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $modalCreateUrl = 'modalCreateUrl';
        $protocol = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
        $site = $protocol . '://'.$_SERVER['HTTP_HOST'] . "/r/";
        
        $urls = User::find(Auth::id())
                    ->links()
                    ->where(
                        function ($query) {
                            $query->where('expired_at', '>=', Carbon::now())
                                ->orWhere('expired_at', '=', null);})
                    ->where('deleted_at', '=', null)
                    ->orderBy('id', 'desc')
                    ->get();            
        
        return view(
            'user', 
            [
                'modalCreateUrl' => $modalCreateUrl,
                'urls' => $urls,
                'site' => $site
            ]
        );
    }

    public function show($users)
    {
        $userUrls = Link::where('user_id', '=', $users)
                        ->where(function ($query) {
                                $query->where('expired_at', '>=', Carbon::now())
                                    ->orWhere('expired_at', '=', null);
                                })
                        ->where('deleted_at', '=', null)
                        ->where('public', '=', 1)
                        ->orderBy('id', 'desc')
                        ->get();
                        
        $user = User::where('id', '=', $users)->first();
        
        if(!$user) {
            return view(
                'notFound', 
                [
                    'errorMessage' => 'Deleted or non-existing user.'
                ]
            );
        }

        $protocol = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
        $site = $protocol . '://'.$_SERVER['HTTP_HOST'] . "/r/";
        
        return view(
            'user', 
            [
                'modalCreateUrl' => 'modalCreateUrl',
                'userUrls' => $userUrls,
                'site' => $site,
                'user' => $user
            ]
        );
    }
}
