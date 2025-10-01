<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $userData = [
            [
                'name'       => 'Admin Gudang',
                'email'      => 'gudang@example.com',
                'password'   => '123456', 
                'role'       => 'gudang',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Admin Dapur',
                'email'      => 'dapur@example.com',
                'password'   => '123456',
                'role'       => 'dapur', 
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert data ke database
        foreach ($userData as $user) {
            $userModel->save($user);
        }

        echo "User seeder completed!\n";
    }
}