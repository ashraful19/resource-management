<?php
namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface WritableRepositoryInterface
{
   /**
    * @param array $attributes
    * @return Model
    */
   public function create(array $attributes): Model;

   /**
    * @param array $attributes
    * @param integer/Model $idOrModel
    * @return Model
    */
   public function update(array $attributes, $idOrModel): Model;

   /**
    * @param $id
    * @return bool
    */
    public function delete($id): ?bool;
}