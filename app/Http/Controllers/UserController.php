<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use File;
use Dirape\Token\Token;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show($id)
    {
        //
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
    public function update(Request $request)
    {
        // Check token.
        $token = $request->header('Authorization');
        $user = (new User)->findUserByToken($token);
        if (is_null($user)) {
            return response()->json([
                'message' => config('message.unauthorized')
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Validator request.
        if ($request->has('nick_name')) {
            if ($user->validationNickName($request->nick_name))
            {
                $user->nick_name = $request->nick_name;
            } else {
                return response()->json([
                    'message' => 'nick_name invalid'
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        if ($request->has('gender'))
        {
            if ($user->validationGender($request->gender))
            {
                $user->gender = $request->gender;
            } else {
                return response()->json([
                    'message' => 'gender invalid'
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        if ($request->hasFile('avatar')) {
            if (!exif_imagetype($request->avatar)) {
                return response()->json([
                    'message' => 'avatar invalid'
                ], Response::HTTP_BAD_REQUEST);
            }

            if ($user->avatar != $user::DEFAULT_AVATAR)
            {
                File::delete(public_path().'/avatar/'.$user->avatar);    
            }

            $file = $request->avatar;
            $nameFile = (new Token())->Unique('users', 'avatar', User::AVATAR_LENGTH).strstr($file->getClientOriginalName(), '.');
            $file->move(public_path().'/avatar',$nameFile);
            $user->avatar = $nameFile;              
        }

        $user->save();
        return response()->json([
            'nick_name' => $user->nick_name,
            'gender' => $user->gender,
            'avatar' => $user->getUrlAvatar($user->avatar),

        ], Response::HTTP_OK);
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
