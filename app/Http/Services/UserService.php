<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\DatabaseManager;

class UserService extends BaseService {

    private $tripRepository;

    public function __construct(DatabaseManager $database, UserRepository $repository) {
        $this->setDatabase($database);
        $this->setRepository($repository);
    }

    public function prepareCreate(array $data) {
        $data["password"] = bcrypt($data['password']);
        $user = $this->repository->create($data);
        return $user;
    }

    public function prepareUpdate(Model $model, array $data) {
        return $this->repository->update($data, $model->id);
    }

    public function prepareDelete($id) {
        $this->repository->delete($id);
    }

    public function getMonopolists() {
        $monopolists = $this->repository->getMonopolists()->toArray();
        $monopolistsPerMonth = $this->repository->getMonopolistsPerMonth()->toArray();
        $monopolistsPerYear = $this->repository->getMonopolistsPerYear()->toArray();
        $all = array('monopolistsAllTime'=>$monopolists,'monopolistsPerMonth'=> $monopolistsPerMonth,'monopolistsPerYear'=> $monopolistsPerYear);
        return $all;
    }

}
