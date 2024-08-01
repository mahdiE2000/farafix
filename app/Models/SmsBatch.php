<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsBatch extends Model
{

    use SoftDeletes , BasicModel;

    protected $fillable = [
        'category' , 'operator' , 'code' , 'fee' , 'type' , 'business_id' , 'is_admin' , 'is_systematic' , 'pattern' , 'from'
    ];

    protected $hidden = [];

    public static function getTableName(): string
    {
        return "sms_batch";
    }

    public function smsList(): HasMany
    {
        return $this->hasMany( Sms::class );
    }

    public function scopeSingle( $query )
    {
        return $query->whereCategory( 'single' );
    }

    public function scopeBatch( $query )
    {
        return $query->whereCategory( 'batch' );
    }

}
