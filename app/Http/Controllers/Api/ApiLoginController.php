<?php

namespace App\Http\Controllers\Api;

use Laravel\Passport\Client;
use App\Traits\ApiResponse;
use App\Traits\TokenTrait;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class ApiLoginController extends AccessTokenController
{
    use TokenTrait, ApiResponse;

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $client = Client::where("password_client", true)->first();
        $requestToken = $this->getCustomToken($request, 'password', "", $client);

        if($requestToken->getStatusCode() === 200) {
            return $requestToken;
        }

        else {
            return $this->err("Usuario o Contraseña no válidos", 401);
        }
    }

}
