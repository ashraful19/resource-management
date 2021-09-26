<?php

namespace App\Repositories;

use App\Models\Resource\PdfResource;
use App\Repositories\Interfaces\PdfResourceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PdfResourceRepository implements PdfResourceRepositoryInterface
{
    protected $model;

    public function __construct(PdfResource $resource)
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
     * @return PdfResource
    */
    public function create(array $attributes): PdfResource
    {
        return $this->model->create($attributes);
    }

    /**
    * @param array $attributes
    * @param integer/PdfResource $idOrModel
    * @return PdfResource
    */
    public function update(array $attributes, $idOrModel): PdfResource
    {
        if($idOrModel instanceof PdfResource)
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
     * @return PdfResource
     */
    public function find($id): ?PdfResource
    {
        return $this->model->find($id);
    }

    /**
     * @param integer/PdfResource $idOrModel
     * @return bool
     */
    public function delete($idOrModel): ?bool
    {
        if($idOrModel instanceof PdfResource)
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
