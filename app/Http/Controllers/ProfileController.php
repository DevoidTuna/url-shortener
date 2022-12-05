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
        $idModal = 'idModal';
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
        
        return view('user', ['idModal' => $idModal,
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
        $idModal = 'idModal';
        $protocol = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
        $site = $protocol . '://'.$_SERVER['HTTP_HOST'] . '/';

        $userName = User::where('id', '=', $users)->get('name');

        $userUrls = Link::where('user_id', '=', $users)
                        ->where(function ($query) {
                                $query->where('expired_at', '>=', Carbon::now())
                                      ->orWhere('expired_at', '=', null);
                                })
                        ->where('deleted_at', '=', null)
                        ->where('public', '=', 1)
                        ->orderBy('id', 'desc')
                        ->get();

        return view('user', ['idModal' => $idModal,
                            'userUrls' => $userUrls,
                            'site' => $site,
                            'userName' => $userName]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
