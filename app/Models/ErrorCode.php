<?php

namespace App\Models;

use App\Services\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ErrorCode extends Model
{
    use BasicModel, SearchableTrait, SoftDeletes;

    protected $fillable = ['error_item_id', 'key', 'value'];

    protected array $searchable = ['error:name', 'key', 'value'];

    public array $mapSearchFields = [
        'error_name' => 'error:name'
    ];

    public static function getTableName(): string
    {
        return "error_codes";
    }

    public function errorItem(): BelongsTo
    {
        return $this->belongsTo(ErrorItem::class,'error_item_id');
    }
}
