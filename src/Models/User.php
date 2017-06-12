<?php
declare(strict_types = 1);
namespace SONFin\Models;

use Illuminate\Database\Eloquent\Model;
use Jasny\Auth\User as JasnyUser;


class User extends Model implements JasnyUser, UserInterface
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password'
    ];

    public function getId(): int
    {
        return (int) $this->id;
    }

    /**
     * Get the usermame
     * 
     * @return string
     */
    public function getUsername():string
    {
        return $this->email;
    }

    /**
     * Get the hashed password
     * 
     * @return string
     */
    public function getHashedPassword(): string
    {
        return $this->password;
    }


    /**
     * Event called on login.
     * 
     * @return boolean  false cancels the login
     */
    public function onLogin()
    {
       
    }

    /**
     * Event called on logout.
     */
    public function onLogout()
    {
        // You might want to log the logout
    }

    public function getFullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function geEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
