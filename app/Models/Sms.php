<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Sms extends Model
{

    use BasicModel;

    protected $fillable = [
        'client_id' , 'status_code' , 'status' , 'message' , 'rel_id' , 'rel_type' , 'cell_number' , 'segment_count' ,
    ];

    protected $hidden = [];

    public static function getTableName(): string
    {
        return "sms";
    }

    public function receiver(): MorphTo
    {
        return $this->morphTo( null , 'rel_type' , 'rel_id' );
    }

    public function smsBatch(): BelongsTo
    {
        return $this->belongsTo( SmsBatch::class );
    }

}
