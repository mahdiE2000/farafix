<?php

namespace App\Models;

use App\Services\Media\HasMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class FakeModel extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['batch_id', 'model_name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public static function getTableName()
    {
        return 'fake_models';
    }

    protected static function getValidCollections(): array
    {
        return [];
    }
}
