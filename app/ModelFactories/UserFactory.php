<?php

namespace App\ModelFactories;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserFactory
{
    const DEFAULT_NAME = 'John';
    const DEFAULT_EMAIL = 'john@gmail.com';
    const DEFAULT_PASSWORD = 'john12345';

    public static function create(string $name, string $email, string $password, bool $hashPassword = true): User
    {

        $newPassword = $password;
        if($hashPassword) {
            $newPassword = Hash::make($password);
        }

        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $newPassword
        ]);
    }
    public static function createWithDefaultValues(bool $hashPassword = true): User
    {
        return UserFactory::create(self::DEFAULT_NAME, self::DEFAULT_EMAIL, self::DEFAULT_PASSWORD, $hashPassword);
    }
}
?>