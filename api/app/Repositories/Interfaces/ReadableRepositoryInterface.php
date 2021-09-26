<?php
namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ReadableRepositoryInterface
{
    /**
    * @param array $withRelations
    * @return Model
    */
   public function all(array $withRelations = []): Collection;

   /**
    * @param $id
    * @return Model
    */
   public function find($id): ?Model;
   
}