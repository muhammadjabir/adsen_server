<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable; 
    use SoftDeletes;

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['foto_profile'];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getFotoProfileAttribute(){
        return $this->foto ? asset('storage/' .$this->foto) : asset('storage/defaultprofile.jpg');
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role(){
        return $this->belongsTo('App\Models\MasterDataDetail','id_role');
    }

    public function category(){
        return $this->belongsTo('App\Models\MasterDataDetail','id_category');
    }

    public function scopeTrainers($query)
    {
        return $query->where('id_role',34);
    }

    public function student(){
        return $this->hasOne('App\Models\Student','id_user');
    }
}
