<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
  private function generateUrl()
  {
    $url = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 8);
    while ($this->CheckShort($url)) {
      $url = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 8);
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
            'status'  => false,
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
        'status'   => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  static function redirectUrl(string $url)
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
      $credentials = Validator::make($request->all(), [
        'user_id'          => ['required', 'integer'],
        'expired_at'      => ['required', 'boolean'],
        'public'          => ['required', 'boolean'],
        'recipient_link'  => ['required', 'string'],
      ]);

      if (!$credentials) {
        return response()->json([
          'status'  => false,
          'message'  => 'validation error'
        ], 401);
      } else {
        if (!$this->CheckShort($request->shortened_link)) {
          return response()->json([
            'status'  => false,
            'message'  => 'Url in use.'
          ], 400);
        }

        $expired = '';
        if ($request->expired_at < 0) {
          $expired = null;
        } else if (is_string($request->expired_at)) {
          str_replace($request->expired_at, ':00', ':01');
          $expired = new Carbon($request->expired_at);
        } else {
          $expired = Carbon::now()->addMinutes($request->expired_at);
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
      }
    } catch (\Throwable $e) {
      return response()->json([
        'status'   => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  public function edit(Request $request)
  {
    try {
      $credentials = Validator::make($request->all(), [
        'id'      => ['required', 'integer'],
        'user_id'  => ['required', 'integer'],
      ]);

      if (!$credentials) {
        return response()->json([
          'status'  => false,
          'message'  => 'validation error'
        ], 401);
      } else {
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
          'status'          => true,
          'message'          => 'URL edited successfully.',
          'shortened_link'  => $url->shortened_link,
        ], 200);
      }
    } catch (\Throwable $th) {
      return response()->json([
        'status'  => false,
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
        'status'  => false,
        'message'  => $th->getMessage()
      ], 500);
    }
  }
}
