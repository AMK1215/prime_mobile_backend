<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserType;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    private const CUSTOMER_ROLE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'name',
        'profile',
        'email',
        'password',
        'phone',
        'status',
        'type',
        'is_changed_password',
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
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user');
    }

    public function hasRole($role)
    {
        return $this->roles->contains('title', $role);
    }


    public static function adminUser()
    {
        return self::where('type', UserType::SystemWallet)->first();
    }


    public function hasPermission($permission)
    {
        // Owner has all permissions
        if ($this->hasRole('Owner')) {
            return true;
        }

        // SystemWallet has all permissions
        if ($this->hasRole('SystemWallet')) {
            return true;
        }

        // Customer has basic access only
        if ($this->hasRole('Customer')) {
            return $this->permissions()
                ->where('title', $permission)
                ->exists();
        }

        // Default: deny permission
        return false;
    }

    public function getAllCustomers()
    {
        // Fetch all customers
        return self::where('type', \App\Enums\UserType::Customer)->get();
    }

    /**
     * Get all customers managed by this owner.
     */
    public function customers()
    {
        return $this->hasMany(\App\Models\Customer::class, 'owner_id');
    }

    /**
     * Find user by username for login.
     */
    public static function findByUsername($username)
    {
        return self::where('user_name', $username)->first();
    }

}
