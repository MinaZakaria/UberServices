<?php

namespace App\Http\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class TripRepository extends Repository {

    public function model() {
        return 'App\Models\Trip';
    }

    public function getTopForHomePage() {
        $topCompanies = $this->model->select('*')
                ->limit(4)
                ->orderBy('no_of_employees', 'desc')
                ->get();
        return $topCompanies;
    }

}
