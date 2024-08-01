<?php

namespace App\Models;

use App\Services\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Request extends Model
{

    use BasicModel , SearchableTrait;

    protected $fillable = [ 'user_id' , 'device_category_id' , 'device_title' , 'description' , 'status' ];

    protected array $searchable = [ 'user:name' , 'user:cell_number' , 'status' ];

    public array $mapSearchFields = [
        'user_name' => 'user:name' ,
        'user_cell_number' => 'user:cell_number' ,
    ];

    public static function getTableName(): string
    {
        return "requests";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class );
    }

    public function address(): MorphOne
    {
        return $this->morphOne( Address::class , "addressable" )->with( "city" );
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany( Address::class , "addressable" )->with( "city" );
    }

    public function getDeviceCategoryAttribute()
    {
        return collect( config( "devices.categories" ) )->where( "id" , $this->device_category_id )->first();
    }

}
