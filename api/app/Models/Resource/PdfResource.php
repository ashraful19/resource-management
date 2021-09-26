<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PdfResource extends Model
{
    use HasFactory;

    protected $table = 'pdf_resources';
    protected $fillable = ['file'];

    public function resource(): MorphOne
    {
        return $this->morphOne(Resource::class, 'resourceable');
    }
}
