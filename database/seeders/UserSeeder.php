<?php  

namespace Database\Seeders;  

use Illuminate\Database\Console\Seeds\WithoutModelEvents;  
use Illuminate\Database\Seeder;  
use App\Models\User;  

class UserSeeder extends Seeder  
{  
    /**  
     * Run the database seeds.  
     */  
    public function run(): void  
    {  
        // Predefined admin account
        User::create([
            'first_name' => 'jimmy',
            'last_name' => 'jimmy',
            'email' => 'jimmyjimmy@gmail.com',
            'password' => md5('jimmyjimmy'), // Store as MD5 hash
            'role' => 'admin',
        ]);

        // Example: Create an IT Commercial user  
        User::create([  
            'first_name' => 'Commercial',  
            'last_name' => 'Team',  
            'email' => 'commercial@example.com',  
            'password' => md5('password'), // Store as MD5 hash
            'role' => 'it',
        ]);  

        // Create one specific client user  
        User::create([  
            'first_name' => 'Test',  
            'last_name' => 'Client',  
            'email' => 'client@example.com',  
            'password' => md5('password'), // Store as MD5 hash
            'role' => 'client',
        ]);  

        // Create 10 more random users with the 'client' role  
        User::factory(10)->create([
            'role' => 'client',
            // Ensure factory also uses MD5 for password
            'password' => md5('password'),
        ]);  
    }  
}