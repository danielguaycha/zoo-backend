<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Traits\TokenTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Client;

class AuthController extends ApiController
{
    use TokenTrait;

    private $client;

    public function __construct(){
        $this->client = Client::where("password_client", true)->first();
        $this->middleware("auth:api")->only(['user', 'logout', 'refresh', 'changePw']);
    }

    public function refresh(Request $request) {
        $this->validate($request, [
            'refresh_token' => 'required'
        ]);
        return $this->issueToken($request, 'refresh_token');
    }

    public function logout() {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);
        $accessToken->revoke();
        return response()->json(['ok'=> true], 204);
    }

    public function user(Request $request) {

        $userId = $request->user()->id;

        $data = User::findOrFail($userId);


        return $this->custom([
            'ok' => true,
            'data' => $data,
        ]);
    }
}
