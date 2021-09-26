<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class LinkResource extends Model
{
    use HasFactory;

    protected $table = 'link_resources';
    protected $fillable = ['url', 'new_tab'];

    public function resource(): MorphOne
    {
        return $this->morphOne(Resource::class, 'resourceable');
    }
}
