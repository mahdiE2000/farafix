<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use App\Services\Media\HasMediaTrait;
use App\Services\Searchable\SearchableTrait;

class ErrorCategory extends Model implements HasMedia
{
    use HasFactory , HasMediaTrait , SearchableTrait;

    protected $fillable = ['name','name_en'];

    public function errorBrands()
    {
        return $this->belongsToMany(ErrorBrand::class, 'error_brand_category');
    }

    public function errors()
    {
        return $this->hasMany(Error::class,'category_id');
    }

}
