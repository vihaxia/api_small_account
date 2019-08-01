<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Model
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'openid',
        'nickname',
        'gender',
        'language',
        'city',
        'country',
        'province',
        'avatar',
        'remember_token'
    ];
}
