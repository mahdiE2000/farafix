<?php

namespace App\Models;

use App\Services\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    use BasicModel , SearchableTrait;

    public static function getTableName(): string
    {
        return "addresses";
    }

    protected $fillable = [ 'city_id' , 'address' , 'phone' , 'postal_code' , 'addressable_id' , 'addressable_type' ];

    protected $with = [ 'city.province' ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo( City::class )->with( 'province' );
    }

}
