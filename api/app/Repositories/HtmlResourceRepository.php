<?php

namespace App\Repositories;

use App\Models\Resource\HtmlResource;
use App\Repositories\Interfaces\HtmlResourceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class HtmlResourceRepository implements HtmlResourceRepositoryInterface
{
    protected $model;

    public function __construct(HtmlResource $htmlResource)
    {
        $this->model = $htmlResource;
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
     * @return HtmlResource
    */
    public function create(array $attributes): HtmlResource
    {
        return $this->model->create($attributes);
    }

    /**
    * @param array $attributes
    * @param integer/HtmlResource $idOrModel
    * @return HtmlResource
    */
    public function update(array $attributes, $idOrModel): HtmlResource
    {
        if($idOrModel instanceof HtmlResource)
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
     * @return HtmlResource
     */
    public function find($id): ?HtmlResource
    {
        return $this->model->find($id);
    }

    /**
     * @param integer/HtmlResource $idOrModel
     * @return bool
     */
    public function delete($idOrModel): ?bool
    {
        if($idOrModel instanceof HtmlResource)
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
