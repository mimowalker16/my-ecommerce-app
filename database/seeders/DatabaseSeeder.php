<?php  

namespace Database\Seeders;  

use App\Models\User;  
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;  
use Illuminate\Database\Seeder;  

class DatabaseSeeder extends Seeder  
{  
    /**  
         * Seed the application's database.  
         */  
        public function run(): void  
        {  
            // Call your specific seeders here  
            $this->call([  
                UserSeeder::class,  
                ProductSeeder::class,  
                // Add other seeders like OrderSeeder, ReviewSeeder later  
            ]);  

        // You can still create a single user here if needed  
        // User::factory()->create([  
        //     'name' => 'Test User',  
        //     'email' => 'test@example.com',  
        // ]);  
    }  
}  