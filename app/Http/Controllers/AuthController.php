<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Requests\PostLoginRequest;
use Carbon\Carbon;

class AuthController extends Controller
{
	public function postLogin(Request $request)
	{
		// Return json when user_name and password are incorrect.
		$user = (new User())->findUserLogin($request);
		if(is_null($user))
		{
			return response()->json([
				'message' => config('message.failed')
			], Response::HTTP_OK);
		}

		// Generator new token and refresh expire.
		$user->api_token = (new User())->generatorNewToken();;
		$user->expire_token = Carbon::now()->addDay(User::TOKEN_TIME_VALID);
		$user->save();
		return response()->json([
			'user' => [
				'user_name' => $user->user_name,
				'gender' => $user->gender,
				'avatar' => $user->getUrlAvatar($user->avatar)
			],
			'token' => $user->api_token
		], Response::HTTP_OK);
	}

	public function getLogout(Request $request)
	{
		// Return status code 400 when token failed validator.
		$token = $request->header('Authorization');
		if (strlen($token) != User::TOKEN_LENGTH)
		{
			return response()->json([
				'message' => config('message.bad_request')
			], Response::HTTP_BAD_REQUEST);
		}

		// Find user by token, if found clear api_token and expire_token of user.
		$user = (new User())->findUserByToken($token);
		if (is_null($user)){
			return response()->json([
				'message' => config('message.failed')
			], Response::HTTP_OK);
		}

		$user->api_token = null;
		$user->expire_token = null;
		$user->save();
		return response()->json([
			'message' => config('message.ok')
		], Response::HTTP_OK);
	}

	public function testHeader(Request $request)
	{
		$token = $request->header('Authorization');
		return response()->json([
			'token' => $token,
			'message' => 'hihihi'
		], Response::HTTP_OK);
	}
}
