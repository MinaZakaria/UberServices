<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Http\Services\TripService;
use App\Http\Helpers\SecurityHelper;
use Carbon\Carbon;

class UserController extends Controller {

    private $userService;
    private $securityHelper;

    public function __construct(UserService $userService, SecurityHelper $securityHelper, TripService $tripService) {
        $this->userService = $userService;
        $this->tripService = $tripService;
        $this->securityHelper = $securityHelper;
    }

    public function new_trip() {
        $user = $this->securityHelper->getCurrentUser();
        $data = array(
            'trips_count' => $user->trips_count + 1,
            'trips_count_per_month' => $user->trips_count_per_month + 1,
            'trips_count_per_year' => $user->trips_count_per_year + 1,
        );
        $this->userService->update($user->id, $data);
        $this->tripService->create(['driver_id' => $user->id, 'trip_date' => Carbon::now()->format('Y-m-d')]);
        return response()->json(["error_code" => 0, "message" => ['count increased successfully']], 200);
    }

    public function getMonopolists() {
        $monopolists = $this->userService->getMonopolists();
        if ($monopolists) {
            return response()->json(["error_code" => 0, "message" => ['data retrieved successfully'],'data'=>$monopolists], 200);
        }
    }

}
