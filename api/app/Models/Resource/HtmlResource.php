<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class HtmlResource extends Model
{
    use HasFactory;

    protected $table = 'html_resources';
    protected $fillable = ['description', 'snippet'];

    public function resource(): MorphOne
    {
        return $this->morphOne(Resource::class, 'resourceable');
    }
}
