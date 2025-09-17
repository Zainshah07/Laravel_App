<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'profile_image',
        'is_active',
        'verification_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'in_active' => 'boolean',
        ];
    }

    /**
     * Mutator: Store profile image automatically in storage/app/public/profile_images
     */
    // public function setProfileImageAttribute($value)
    // {
    //     if ($value && is_file($value)) {
    //         // Store the file and set the path in DB
    //         $this->attributes['profile_image'] = $value->store('profile_images', 'public');
    //     }
    // }

    //  * Accessor: Always return full URL of profile image
    //  */
    public function getProfileImageAttribute($value)
    {
        return $value ? asset('storage/'.$value) : asset('default-profile.png');
        // fallback image if user has no profile image
    }
}
