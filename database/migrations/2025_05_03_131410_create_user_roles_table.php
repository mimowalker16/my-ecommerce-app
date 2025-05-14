<?php  

use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;  
use Illuminate\Support\Facades\DB; // Import DB facade  

return new class extends Migration  
{  
    public function up(): void  
    {  
        Schema::create('user_roles', function (Blueprint $table) {  
            $table->id();  
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Delete role if user is deleted  
            $table->string('role'); // text not null  
            $table->timestamps();  

             // Optional: Prevent assigning the same role multiple times to the same user  
            // $table->unique(['user_id', 'role']);  
        });  

        // Add CHECK constraint using raw SQL (adjust SQL for your specific DB)  
        // For PostgreSQL:  
        // DB::statement("ALTER TABLE user_roles ADD CONSTRAINT user_roles_role_check CHECK (role IN ('client', 'it_commercial', 'admin'))");  
        // For MySQL 8.0.16+:  
         DB::statement("ALTER TABLE user_roles ADD CONSTRAINT user_roles_role_check CHECK (role IN ('client', 'it_commercial', 'admin'))");  
        // Older MySQL/MariaDB don't enforce CHECK constraints. Use application validation.  

    }  

    public function down(): void  
    {  
        Schema::dropIfExists('user_roles');  
    }  
};  