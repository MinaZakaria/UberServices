<?php

namespace App\Http\Services;

use \Exception;
use Illuminate\Database\DatabaseManager;
use \Bosnadev\Repositories\Eloquent\Repository;
use \Illuminate\Database\Eloquent\Model;

abstract class BaseService {

    private $database;

    public function setDatabase(DatabaseManager $database) {
        $this->database = $database;
    }

    protected $repository;

    public function setRepository(Repository $repository) {
        $this->repository = $repository;
    }

    abstract public function prepareCreate(array $data);

    abstract public function prepareUpdate(Model $model, array $data);

    abstract public function prepareDelete($id);

    public function getAll() {
        return $this->repository->all();
    }

    public function getById($id, $columns = array('*')) {
        $model = $this->repository->find($id, $columns);

        return $model;
    }

    public function create(array $data) {
        $this->database->beginTransaction();

        try {
            $model = $this->prepareCreate($data);
        } catch (Exception $e) {
            $this->database->rollBack();
            throw $e;
        }

        $this->database->commit();

        return $model;
    }

    public function update($id, array $data) {
        $model = $this->repository->find($id);
        $this->database->beginTransaction();

        try {
            $ret = $this->prepareUpdate($model, $data);            
        } catch (Exception $e) {
            $this->database->rollBack();

            throw $e;
        }

        $this->database->commit();

        return $ret;
    }

    public function delete($id) {
        $this->database->beginTransaction();

        try {
            $this->prepareDelete($id);
        } catch (Exception $e) {
            $this->database->rollBack();

            throw $e;
        }

        $this->database->commit();
    }

}
