<?php
declare(strict_types = 1);
namespace SONFin\Repository;

use Illuminate\Database\Eloquent\Model;

class DefaultRepository implements RepositoryInterface
{
    private $className;

    /**
    *@var Model
    */
    private $model;


    function __construct(string $className)
    {
        $this->className = $className;
        $this->model = new $className;
    }

    public function all(): array
    {
        return $this->model->all()->toArray();
    }

    public function find(int $id, bool $failIfNotExists = true)
    {
        return $failIfNotExists ? $this->model->findOrFail($id) : $this->model->find($id);
    }

    public function findByField(string $field, $value)
    {
        return $this->model->where($field, '=', $value)->get();
    }

    public function create(array $data)
    {
        $this->model->fill($data);
        $this->model->save();
        return $this->model;
    }

    public function update($id, array $data)
    {
        $model = $this->findInternal($id);
        $model->fill($data);
        $model->save();
        return $model;
    }

    public function delete($id)
    {
        $model = $this->findInternal($id);
        $model->delete();
    }

    public function findOneBy(array $search)
    {
        $queryBuilder = $this->model;
        foreach ($search as $field => $value) {
            $queryBuilder = $queryBuilder->where($field, '=', $value);
        }
        return $queryBuilder->firstOrFail();
    }

    protected function findInternal($id)
    {
        return is_array($id) ? $this->findOneBy($id) : $this->model->find($id);
    }
}
