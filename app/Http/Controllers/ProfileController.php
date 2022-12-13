<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modalCreateUrl = 'modalCreateUrl';
        $protocol = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
        $site = $protocol . '://'.$_SERVER['HTTP_HOST'] . '/';
        
        $urls = Link::where('user_id', '=', auth()->id())
                    ->where(
                    function ($query) {
                        $query->where('expired_at', '>=', Carbon::now())
                                ->orWhere('expired_at', '=', null);})
                    ->where('deleted_at', '=', null)
                    ->orderBy('id', 'desc')
                    ->get();                    
        
        return view('user', ['modalCreateUrl' => $modalCreateUrl,
                            'urls' => $urls,
                            'site' => $site
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
                        
        $userName = User::where('id', '=', $users)->get('name');
        
        if(count($userName) == 0) {
            $errorMessage = 'Deleted or non-existing user.';
            return view('notFound', ['errorMessage' => $errorMessage]);
        }

        $modalCreateUrl = 'modalCreateUrl';
        $protocol = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
        $site = $protocol . '://'.$_SERVER['HTTP_HOST'] . '/';
        

        return view('user', ['modalCreateUrl' => $modalCreateUrl,
                            'userUrls' => $userUrls,
                            'site' => $site,
                            'userName' => $userName]);
        
    }
}
