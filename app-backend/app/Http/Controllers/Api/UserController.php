<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserEmailRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showUserInfo(Request $request)
    {
        /** @var User $user */
        $user = User::where('id',$request['id'])->first();

        return response([
            'id' => $user['id'],
            'email' => $user['email']
        ]);
    }

    public function updateUserEmail(UpdateUserEmailRequest $request)
    {
        $data = $request->validated();

        /** @var User $user */
        $user = User::where('id',$data['id'])->first();

        if(!$user) return response(['','422']);

        if(isset($data['email']) && $data['email'] != $user['email']) {
            $user->update(['email' => $data['email']]);
            return response('Email aggiornata con successo', '204');
        }

        return response(['','422']);
    }
    public function updateUserPassword(UpdateUserPasswordRequest $request)
    {
        $data = $request->validated();

        if(isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        /** @var User $user */
        $user = User::where('id',$data['id'])->first();

        if(!$user) return response(['','422']);

        if(isset($data['password']) && $data['password'] != $user['password']) {
            $user->update(['password' => $data['password']]);
            return response("Password aggiornata con successo",'204');
        }

        return response(['','422']);
    }

    public function deleteUser(Request $request) {

        /** @var User $user */
        $user = User::where('id',$request['id'])->first();

        //if(!$user) return response(['','422']);

        $user->delete();

        return response('User eliminato con successo','204');
    }
}
