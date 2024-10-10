<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SuperAdmin  extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $table = 'superadmin';
    protected $fillable = [
        'username',
        'password',
        'email',
    ];
}
