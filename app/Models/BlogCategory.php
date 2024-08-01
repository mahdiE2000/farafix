<?php

namespace App\Models;

use App\Services\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class BlogCategory extends Model
{
    use NodeTrait, BasicModel, SearchableTrait, SoftDeletes;

    protected $fillable = ['title', 'description', 'parent_id'];

    protected array $searchable = ['title', "parent_id"];

    public array $mapSearchFields = [];

    public static function getTableName(): string
    {
        return "blog_categories";
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(get_class($this), $this->getParentIdName())->setModel($this);
    }

    public function children(): HasMany
    {
        return $this->hasMany(get_class($this), $this->getParentIdName())->setModel($this);
    }
}
