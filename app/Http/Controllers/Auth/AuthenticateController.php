<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Services\UserService;
use Validator;

class AuthenticateController extends Controller {

    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function authenticate(Request $request) {

        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        if(! isset($credentials['password']) || ! isset($credentials['password'])){
            return response()->json(["error_code" => 3, "message" => ['email or password not provided']], 400);
        }
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error_code' => 4, 'message' => ['invalid_credentials']], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error_code' => 1, 'message' => ['could_not_create_token']], 500);
        }
        // all good so return the token
        return response()->json(['error_code' => 0, 'message' => ['token generated successfully'],'token'=>$token], 200);
    }

    public function getAuthenticatedUser() {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function register(Request $request) {

        $data = $request->all();
        $validator = Validator::make($data, User::$rules['save']);
        if ($validator->fails()) {
            return response()->json(["error_code"=> 3, "message" => $validator->errors()->all()], 400);
        }
        $created = $this->userService->create($data);
        if (! $created) {
            return response()->json(['error_code' => 1, 'message' => ['something went wrong']], 500);
        }
        return response()->json(['error_code' => 0, 'message' => ['created successfully']], 200);
    }

}
