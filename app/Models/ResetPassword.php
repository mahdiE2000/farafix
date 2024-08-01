<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{

    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $table = 'reset_passwords';

    protected $fillable = [
        'cell_number' , 'code'
    ];

}
