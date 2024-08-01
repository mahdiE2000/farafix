<?php

namespace App\Models;

use App\Services\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use BasicModel , SearchableTrait , SoftDeletes;

    protected $fillable = [ 'product_id' , 'key' , 'value' ];

    protected array $searchable = [ 'product:name' , 'key' , 'value' ];

    public array $mapSearchFields = [
        'product_name' => 'product:name'
    ];

    public static function getTableName(): string
    {
        return "product_variations";
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo( Product::class );
    }
}
