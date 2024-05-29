<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Request;

class InfoAccountController extends Controller
{

    public function email(Request $request)
    {
        /** @var User $user */
        $user = User::find($request);

        return response([
            'email' => $user['email']
        ]);
    }
}
