<?php

namespace App\Models;

use App\Services\Media\HasMediaTrait;
use App\Services\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;

class ErrorItem extends Model implements HasMedia
{
    use HasMediaTrait, BasicModel, SearchableTrait, SoftDeletes;

    protected $fillable = ['name','title', 'title_en', 'error_id', 'summary', 'description'];

    protected array $searchable = ['name', 'title', 'error_id', 'title_en', 'summary'];

    public array $mapSearchFields = [];

    public static function getTableName(): string
    {
        return "error_items";
    }

    public function errorCodes(): HasMany
    {
        return $this->hasMany(ErrorCode::class,'error_item_id');
    }

    public function error(): BelongsTo
    {
        return $this->belongsTo(Error::class, "error_id");
    }
}
