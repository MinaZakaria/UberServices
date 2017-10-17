<?php

namespace App\Http\Helpers;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Services\UserService;

class SecurityHelper {

    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function getCurrentUserId() {
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            if (!$payload->get('sub')) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return $payload->get('sub');
    }

    public function getCurrentUser() {
        $userId = $this->getCurrentUserId();
        $user = $this->userService->getById($userId);
        return $user;
    }

}
