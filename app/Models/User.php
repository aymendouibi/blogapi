<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable; // Import the Authenticatable trait
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable 

{
    use HasFactory, Notifiable,HasApiTokens;
    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Define the relationship with blogs
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
