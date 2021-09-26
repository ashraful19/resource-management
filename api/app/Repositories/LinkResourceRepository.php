<?php

namespace App\Repositories;

use App\Models\Resource\LinkResource;
use App\Repositories\Interfaces\LinkResourceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class LinkResourceRepository implements LinkResourceRepositoryInterface
{
    protected $model;

    public function __construct(LinkResource $linkResource)
    {
        $this->model = $linkResource;
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
     * @return LinkResource
    */
    public function create(array $attributes): LinkResource
    {
        return $this->model->create($attributes);
    }

    /**
    * @param array $attributes
    * @param integer/LinkResource $idOrModel
    * @return LinkResource
    */
    public function update(array $attributes, $idOrModel): LinkResource
    {
        if($idOrModel instanceof LinkResource)
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
     * @return LinkResource
     */
    public function find($id): ?LinkResource
    {
        return $this->model->find($id);
    }

    /**
     * @param integer/LinkResource $idOrModel
     * @return bool
     */
    public function delete($idOrModel): ?bool
    {
        if($idOrModel instanceof LinkResource)
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
