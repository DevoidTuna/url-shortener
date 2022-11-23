<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function generateUrl()
    {
        $url = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 15);
        return $url;
    }

    public function findUrlInDatabase(string $url)
    {
        # aguardar Aula do João
    }
    
    # Prosseguir após a ligação com o João
    public function store(Request $request)
    {
        $expired = '';

        if ($request->expiration < 0) {
            $expired = Carbon::now()->addYears(100);
        } else {
            $expired = Carbon::now()->addMinutes($request->expiration);
        }

        $public = '';

        if ($request->public == 'true') {
            $public = '1';
        } else {
            $public = '';
        }


        $url = Link::create([
            'user_id' => auth()->id(),
            'name_link' => $request->nameUrl,
            'shortened_link' => $this->generateUrl(),
            'recipient_link' => $request->destinationUrl,
            'expired_at' => $expired,
            'public' => $public,
            'deleted' => '',
        ]);

        $namePage = 'Profile';
        $idModal = 'idModal';
        return view('user',  ['namePage' => $namePage, 'idModal' => $idModal]);
    }
}
