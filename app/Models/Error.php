<?php

namespace App\Models;

use App\Services\Media\HasMediaTrait;
use App\Services\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;

class Error extends Model implements HasMedia
{
    use HasMediaTrait, BasicModel, SearchableTrait, SoftDeletes;

    protected $fillable = ['name', 'title', "title_en", 'description', 'date','category_id','brand_id'];

    protected array $searchable = ['name', 'title', 'title_en', "date"];

    public array $mapSearchFields = [];

    protected $table = 'errors';


    public static function getTableName(): string
    {
        return "errors";
    }

    public function errorCategory()
    {
        return $this->belongsTo(ErrorCategory::class,'category_id');
    }

    public function errorBrand()
    {
        return $this->belongsTo(ErrorBrand::class,'brand_id');
    }

    public function errorItems(): HasMany
    {
        return $this->hasMany(ErrorItem::class , "error_id");
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_image')->singleFile();
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $crop = $media->getCustomProperty('crop');
        $conversion = $this->addMediaConversion('thumbnail');
        $conversion = ! $crop ? $conversion : $conversion->manualCrop($crop[ 'width' ], $crop[ 'height' ], $crop[ 'left' ], $crop[ 'top' ]);
        $conversion->nonQueued()
            ->performOnCollections('main_image');
    }

    protected static function getValidCollections(): array
    {
        return [
            'main_image'
        ];
    }
}
