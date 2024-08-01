<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use App\Services\Media\HasMediaTrait;
use App\Services\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;

class Product extends Model implements HasMedia
{
    use HasMediaTrait , BasicModel , SearchableTrait , SoftDeletes;

    protected $fillable = [ 'title' , 'title_en' , 'category_id' , 'summary' , 'description' , 'creator_id' ];

    protected array $searchable = [ 'category:name' , 'title' , 'title_en' , 'summary' ];

    public array $mapSearchFields = [
        'category_name' => 'category:name'
    ];

    public static function getTableName(): string
    {
        return "products";
    }

    public static function boot()
    {
        parent::boot();

        if (! app()->runningInConsole()) {
            static::addGlobalScope( new OrderByIdScope );
        }
        static::creating(function ($model) {
            $model->creator_id = auth()->id();
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo( ProductCategory::class );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo( User::class , "creator_id");
    }

    public function variations(): HasMany
    {
        return $this->hasMany( ProductVariation::class );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection( 'main_image' )->singleFile();
    }

    public function registerMediaConversions( \Spatie\MediaLibrary\MediaCollections\Models\Media $media = null ): void
    {
        $crop = $media->getCustomProperty( 'crop' );
        $conversion = $this->addMediaConversion( 'thumbnail' );
        $conversion = ! $crop ? $conversion : $conversion->manualCrop( $crop[ 'width' ] , $crop[ 'height' ] , $crop[ 'left' ] , $crop[ 'top' ] );
        $conversion->nonQueued()
            ->performOnCollections( 'main_image' );

        $this->addMediaConversion( 'thumbnail' )
            ->width( 400 )
            ->nonQueued()
            ->performOnCollections( 'images' );
    }

    protected static function getValidCollections(): array
    {
        return [
            'main_image' ,
            'images'
        ];
    }
}
