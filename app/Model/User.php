<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Model
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'id',
        'name',
        'email',
        'email_verified_at',
        'username',
        'phone',
        'weapp_openid',
        'nickname',
        'weapp_avatar',
        'country',
        'province',
        'city',
        'language',
        'location',
        'gender',
        'level',//用户等级
        'is_admin',//is管理员
    ];
}
