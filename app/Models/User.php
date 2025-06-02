<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method bool hasRole(string|array $roles, string|null $guard = null)
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }
    
    /**
     * read notification from spesific transaction
     *
     * @param \Illuminate\Database\Eloquent\Model $transaski
     */
    public function markAsReadNotificationFor($model)
    {
        return $this->unreadNotifications()->where([
            ['model_id', $model->id],
            ['model_type', get_class($model)]
        ])->update(['read_at' => now()]);
    }

    /**
     * Get the vendor associated with the user.
     */
    public function vendor()
    {
        return $this->hasOne(Vendor::class);
        
    }

    // Tambahkan di dalam class User:
    public function createdRfqs()
    {
        return $this->hasMany(Rfq::class, 'created_by');
    }

    // Method helper untuk admin
    public function canManageRfq(): bool
    {
        return $this->hasRole(['admin_logistik']);
    }
}
