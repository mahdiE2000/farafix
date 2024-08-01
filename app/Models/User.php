<?php

namespace App\Models;

use App\Services\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens , HasFactory , Notifiable , SoftDeletes , BasicModel , SearchableTrait;

    protected $fillable = [
        'name' , 'password' , 'cell_number' , 'role' , 'verified'
    ];

    protected $hidden = [
        'password' , 'remember_token' ,
    ];

    public array $messageFields = [
        'name' , 'cell_number'
    ];

    protected array $searchable = [ 'name' , 'cell_number' ];

    public array $mapSearchFields = [];

    public static function getTableName(): string
    {
        return "users";
    }

    public function isVerified(): bool
    {
        return $this->attributes[ 'verified' ] === 1;
    }

    public function getPhone()
    {
        return $this->cell_number;
    }

    public function requests(): HasMany
    {
        return $this->hasMany( Request::class );
    }
}
