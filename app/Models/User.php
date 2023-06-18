<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
    ];
    private static $role_approval_mapping = [
        'lid' => 'is_approved_member',
        'opdrachtgever' => 'is_approved_client',
        'coordinator' => 'is_approved_coordinator',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_approved' => 'boolean',
    ];

    public function client() 
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }
    public function userTasks()
{
    return $this->hasMany(UserTask::class);
}

public function getApprovalAttributeForRole($roleName)
{
    $attribute = self::$role_approval_mapping[strtolower($roleName)] ?? null;

    if ($attribute) {
        return $attribute;
    }

    throw new InvalidArgumentException("Unknown role: $roleName");
}
public function isRoleApprovalFirstTime()
{
    foreach (self::$role_approval_mapping as $role => $column) {
        if ($this->$column) {
            return false;
        }
    }
    return true;
}
public function hasApprovedRole()
{
    foreach (self::$role_approval_mapping as $role => $column) {
        if ($this->$column) {
            return true;
        }
    }
    return false;
}




}


// namespace App\Models;

// // use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

// class User extends Authenticatable
// {
//     use HasApiTokens, HasFactory, Notifiable;

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var array<int, string>
//      */
//     protected $fillable = [
//         'name',
//         'email',
//         'password',
//         'phoneNumber',
//         'role',
//     ];

//     /**
//      * The attributes that should be hidden for serialization.
//      *
//      * @var array<int, string>
//      */
//     protected $hidden = [
//         'password',
//         'remember_token',
//     ];

//     /**
//      * The attributes that should be cast.
//      *
//      * @var array<string, string>
//      */
//     protected $casts = [
//         'email_verified_at' => 'datetime',
//         'password' => 'hashed',
//     ];
// }
