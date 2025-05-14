<?php  

use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;  

return new class extends Migration  
{  
    /**  
     * Run the migrations.  
     */  
    public function up(): void  
    {  
        Schema::create('users', function (Blueprint $table) {  
            $table->id(); // Corresponds to bigint primary key generated always as identity  
            $table->string('first_name'); // Using string instead of text for names is common  
            $table->string('last_name');  
            $table->text('address')->nullable(); // Allow address to be optional  
            $table->string('email')->unique(); // Keep Laravel's default email  
            $table->string('role')->default('client');
            //$table->timestamp('email_verified_at')->nullable(); // Keep if you want email verification later  
            $table->string('password'); // Keep Laravel's default password handling  
            $table->string('credit_card_number')->nullable(); // Storing raw CC numbers is highly insecure! Consider payment gateway integration instead.  
            //$table->rememberToken(); // Keep if you want "remember me" functionality  
            $table->timestamps(); // Adds created_at and updated_at columns  
        });  

        // Optional: Add indexes for faster lookups if needed  
        // Schema::table('users', function (Blueprint $table) {  
        //     $table->index('email');  
        // });  
    }  

    /**  
     * Reverse the migrations.  
     */  
    public function down(): void  
    {  
        Schema::dropIfExists('users');  
    }  
};  