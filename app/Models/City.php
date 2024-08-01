<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{

    use BasicModel;

    public static function getTableName(): string
    {
        return "cities";
    }

    protected $fillable = [ 'name_fa' , 'name_en' , 'latitude' , 'longitude' , 'view' , 'parent_id' ];

    public function cities(): HasMany
    {
        return $this->hasMany( City::class , 'parent_id' )->setModel( $this );
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo( City::class , 'parent_id' )->setModel( $this );
    }
}
