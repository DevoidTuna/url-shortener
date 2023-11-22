<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
	public function index()
	{
		try {
			$protocol = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on") ? "https" : "http");
			$site = $protocol . '://' . $_SERVER['HTTP_HOST'] . "/r/";

			$urlsArr = User::find(Auth::id())
				->links()
				->where(
					function ($query) {
						$query->where('expired_at', '>=', Carbon::now())
							->orWhere('expired_at', '=', null);
					}
				)
				->where('deleted_at', '=', null)
				->orderBy('id', 'desc')
				->get();

			$urls = (object) $urlsArr;

			return response()->json([
				'site' => $site,
				'urls' => $urls
			], 200);
		} catch (\Throwable $e) {
			return response()->json([
				'status' => false,
				'message' => $e->getMessage()
			], 500);
		}
	}

	public function show(Request $users)
	{
		try {
			$user = User::where('id', '=', $users->id)
				->select('nickname', 'id')
				->first();

			if (!$user) {
				return response()->json([
					'status' => false,
					'message' => 'User not found.'
				], 404);
			}

			$userUrls = Link::where('user_id', '=', $user->id)
				->where(function ($query) {
					$query->where('expired_at', '>=', Carbon::now())
						->orWhere('expired_at', '=', null);
				})
				->where('deleted_at', '=', null)
				->where('public', '=', 1)
				->orderBy('id', 'desc')
				->get();

			return response()->json([
				'urls' => $userUrls,
				'user' => $user
			], 200);
		} catch (\Throwable $e) {
			return response()->json([
				'status' => false,
				'message' => $e->getMessage()
			], 500);
		}
	}
}
