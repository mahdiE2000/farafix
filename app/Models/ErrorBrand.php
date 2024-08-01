<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorBrand extends Model
{
    use HasFactory;

    protected $fillable = ['name','name_en'];

    public function errorCategories()
    {
        return $this->belongsToMany(ErrorCategory::class, 'error_brand_category');
    }
    public function errors()
    {
        return $this->hasMany(Error::class,'brand_id');
    }
}
