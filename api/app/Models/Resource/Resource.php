<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Resource extends Model
{
    use HasFactory;

    protected $table = 'resources';
    protected $fillable = ['title', 'resourceable_type', 'resourceable_id'];
    protected $appends = ['type', 'type_id'];

    public function getTypeAttribute(): string
    {
        return $this->resourceable_type;
    }

    public function getTypeIdAttribute(): string
    {
        return $this->resourceable_id;
    }

    public function resourceable(): MorphTo
    {
        return $this->morphTo();
    }
}
