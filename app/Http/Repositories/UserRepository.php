<?php

namespace App\Http\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use App\User;

class UserRepository extends Repository {

    public function model() {
        return 'App\User';
    }

    public function getMonopolists() {
        return $this->model->select("name","trips_count")
                        ->where("trips_count", ">=", function($query) {
                            $query->selectRaw("sum(trips_count)/10")
                            ->from(with(new User)->getTable());
                        })
                        ->get();
    }

    public function getMonopolistsPerMonth() {
        return $this->model->select("name","trips_count_per_month")
                        ->where("trips_count_per_month", ">=", function($query) {
                            $query->selectRaw("sum(trips_count_per_month)/10")
                            ->from(with(new User)->getTable());
                        })
                        ->get();
    }

    public function getMonopolistsPerYear() {
        return $this->model->select("name","trips_count_per_year")
                        ->where("trips_count_per_year", ">=", function($query) {
                            $query->selectRaw("sum(trips_count_per_year)/10")
                            ->from(with(new User)->getTable());
                        })
                        ->get();
    }

}
