<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create owner (password required for login)
        $this->createUser(
            UserType::Owner,
            'Owner',
            'OWNER001',
            '09123456789'
        );

        // Create system wallet (no password needed)
        $this->createUser(
            UserType::SystemWallet,
            'System Wallet',
            'SYS001',
            '09222222222',
            false // no password
        );
    }

    private function createUser(
        UserType $type,
        string $name,
        string $user_name,
        string $phone,
        bool $needsPassword = true
    ): User {
        $userData = [
            'name' => $name,
            'user_name' => $user_name,
            'phone' => $phone,
             'password' => Hash::make('gscplus'),
            'status' => 1,
            'is_changed_password' => 1,
            'type' => $type->value,
        ];

        // Only set password for Owner (who needs to login)
        // if ($needsPassword && $type === UserType::Owner) {
        //     $userData['password'] = Hash::make('gscplus');
        // }

        return User::create($userData);
    }
}
