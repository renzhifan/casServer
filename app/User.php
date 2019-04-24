<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Leo108\CAS\Contracts\Models\UserModel;
class User extends Authenticatable implements UserModel
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * 获取用户名
     * 需要保证用户名在 CAS 系统中的唯一性，
     * 我们在 CAS Client 通过它的值来唯一确定用户
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 获取用户属性
     *
     * @return array
     */
    public function getCASAttributes()
    {
        return $this->attributesToArray();
    }

    /**
     * 获取用户模型实例
     *
     * @return Model
     */
    public function getEloquentModel()
    {
        return $this;
    }
}
