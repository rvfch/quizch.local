<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
      $http = new \GuzzleHttp\Client;
      try {
        $resp = $http->post(env('APP_URL', 'http://localhost').'/oauth/token', [
            'form_params' => [
              'grant_type' => 'password',
              'client_id' => 2,
              'client_secret' => '8gOY2BrD0y3yyPM2zXrfDRosCFtGwry2VESODzaO',
              'username' => $request->username,
              'password' => $request->password,
            ]
          ]);
          return $resp->getBody();
      } catch (\GuzzleHttp\Exception\BadResponseException $err) {
        if ($err->getCode() == 400) {
          return response()->json('INVALID_REQUEST', $err->getCode());
        } else if ($err->getCode() == 401) {
          return response()->json('INCORRECT_DATA', $err->getCode());
        }
        return response()->json('AUTH_ERROR', $err->getCode());
      }
    }

    public function register(Request $request) {
      $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
      ]);

      return User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
      ]);
    }

    public function logout() {
      auth()->user()->tokens->each(function ($token, $key) {
        $token->delete();
      });
      return response()->json('LOGGED_OUT_OK', 300);
    }
}
