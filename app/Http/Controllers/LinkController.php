<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
  private function generateUrl()
  {
    $url = Str::random(8);
    while ($this->CheckShort($url)) {
      $url = Str::random(8);
    }
    return $url;
  }

  public function CheckShort($short)
  {
    try {
      if (empty($short)) {
        return response()->json([
          'message'  => 'Title avaliable.',
        ], 200);
      } else {
        $link = Link::where('shortened_link', '=', $short)
          ->where(function ($query) {
            $query->where('expired_at', '>=', Carbon::now())
              ->orWhereNull('expired_at');
          })
          ->whereNull('deleted_at')
          ->first();

        if ($link) {
          return response()->json([
            'message'  => 'Personalized title in use.',
          ], 400);
        } else {
          return response()->json([
            'message'  => 'Title avaliable.',
          ], 200);
        }
      }
    } catch (\Throwable $e) {
      return response()->json([
        'message' => $e->getMessage()
      ], 500);
    }
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

    if (empty($shortUrl)) return redirect('/not-found');
    return redirect($shortUrl->recipient_link);
  }

  // Check if url has protocol and if not, insert it
  private function checkLinkFormat(string $url)
  {
    if (strpos($url, 'http://') !== false || strpos($url, 'https://') !== false) {
      return $url;
    } else {
      return 'https://' . $url;
    }
  }

  public function store(Request $request)
  {
    try {
      $request->validate([
        'user_id'          => ['required', 'integer'],
        'expired_at'      => ['required', 'boolean'],
        'public'          => ['required', 'boolean'],
        'recipient_link'  => ['required', 'string'],
      ]);

      if (!$this->CheckShort($request->shortened_link)) {
        return response()->json([
          'message'  => 'Url in use.'
        ], 400);
      }

      $expired = '';
      $expiration = $request->expired_at;
      if ($request->expired_at < 0) {
        $expired = null;
      } else if (is_string($expiration)) {
        str_replace($expiration, ':00', ':01');
        $expired = new Carbon($expiration);
      } else {
        $expired = Carbon::now()->addMinutes($expiration);
      }

      $short = '';
      if ($request->shortened_link) {
        $short = preg_replace('/[^0-9a-zA-Z-]/', '', $request->shortened_link);
        $short = str_replace(' ', '-', $request->shortened_link);
      } else {
        $short = $this->generateUrl();
      }

      Link::create([
        'user_id'          => auth()->id(),
        'shortened_link'  => $short,
        'recipient_link'  => $this->checkLinkFormat($request->recipient_link),
        'expired_at'      => $expired,
        'public'          => $request->public
      ]);

      return response()->json([
        'message'  => 'successfully shortened link',
      ], 200);
    } catch (\Throwable $e) {
      return response()->json([
        'message' => $e->getMessage()
      ], 500);
    }
  }

  public function edit(Request $request)
  {
    try {
      $request->validate([
        'id'      => ['required', 'integer'],
        'user_id'  => ['required', 'integer'],
      ]);

      $url = Link::where([
        ['id',      '=', $request->id],
        ['user_id',  '=', $request->user_id],
      ])->first();

      if (empty($request->shortened_link)) {
        $url->shortened_link = $this->generateUrl();
      } else {
        $short = preg_replace('/[^0-9a-zA-Z-]/', '', $request->shortened_link);
        $short = str_replace(' ', '-', $request->shortened_link);
        $url->shortened_link = $short;
      }

      $url->save();

      return response()->json([
        'message'          => 'URL edited successfully.',
        'shortened_link'  => $url->shortened_link,
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'message'  => $th->getMessage()
      ], 500);
    }
  }

  public function destroy(Request $request)
  {
    try {
      Link::where('id', '=', $request->id)->delete();
      return response()->json([
        'message'  => 'URL deleted successfully.'
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'message'  => $th->getMessage()
      ], 500);
    }
  }
}
