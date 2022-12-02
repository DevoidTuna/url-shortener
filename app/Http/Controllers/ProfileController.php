<?php

namespace App\Http\Controllers;

use App\Models\Link;
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
        $namePage = 'Profile';
        $idModal = 'idModal';
        $urls = Link::where('user_id', '=', auth()->id())
                    ->where('expired_at', '>=', Carbon::now())
                    ->orWhere('expired_at', '=', null)
                    ->where('deleted_at', '=', null)
                    ->orderBy('id', 'desc')
                    ->get();

        $protocol = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
        $site = $protocol . '://'.$_SERVER['HTTP_HOST'] . '/';
        return view('user', [
            'namePage' => $namePage,
            'idModal' => $idModal,
            'urls' => $urls,
            'site' => $site
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $namePage = 'User';
        return view('user', ['user' => $user, 'namePage' => $namePage]);
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
