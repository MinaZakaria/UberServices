<?php

namespace App\Http\Services;

use App\Http\Repositories\TripRepository;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\DatabaseManager;

class TripService extends BaseService {
    
    public function __construct(DatabaseManager $database, TripRepository $repository) {
        $this->setDatabase($database);
        $this->setRepository($repository);
    }
    
    public function prepareCreate(array $data) {
        $artist = $this->repository->create($data);
        return $artist;
    }

    public function prepareUpdate(Model $model, array $data) {
        return $this->repository->update($data, $model->id);
    }

    public function prepareDelete($id) {
        $this->repository->delete($id);
    }
    
}
