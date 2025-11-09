<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role',
        'phone',
        'profile_photo',
        'nim',
        'jurusan',
        'angkatan',
        'is_active'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }


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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // Fixed the timestamp castings in the $casts property above

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is student
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Get profile photo URL
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo && Storage::disk('public')->exists($this->profile_photo)) {
            return Storage::url($this->profile_photo);
        }
        
        // Default avatar based on role
        return $this->isAdmin() 
            ? 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0D8ABC&color=fff&size=200'
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=4CAF50&color=fff&size=200';
    }

    /**
     * Get user peminjaman
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'user_id');
    }

    /**
     * Scope active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by role
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }
}