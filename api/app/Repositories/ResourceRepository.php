<?php

namespace App\Repositories;

use App\Models\Resource\Resource;
use App\Repositories\Interfaces\ResourceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ResourceRepository implements ResourceRepositoryInterface
{
    protected $model;

    public function __construct(Resource $resource)
    {
        $this->model = $resource;
    }

    /**
     * @param array $withRelations
     * @return Collection
    */
    public function all(array $withRelations = []): Collection
    {
        return $this->model->with($withRelations)->latest()->get();
    }

    /**
     * @param array $attributes
     * @return Resource
    */
    public function create(array $attributes): Resource
    {
        return $this->model->create($attributes);
    }

    /**
    * @param array $attributes
    * @param integer/Resource $idOrModel
    * @return Resource
    */
    public function update(array $attributes, $idOrModel): Resource
    {
        if($idOrModel instanceof Resource)
        {
            $record = $idOrModel;
        }
        else
        {
            $record = $this->model->findOrFail($idOrModel);
        }
        $record->update($attributes);
        return $record;
    }

    /**
     * @param integer $id
     * @return Resource
     */
    public function find($id): ?Resource
    {
        return $this->model->find($id);
    }

    /**
     * @param integer/Resource $idOrModel
     * @return bool
     */
    public function delete($idOrModel): ?bool
    {
        if($idOrModel instanceof Resource)
        {
            $record = $idOrModel;
        }
        else
        {
            $record = $this->model->findOrFail($idOrModel);
        }
        return $record->delete();
    }
}
