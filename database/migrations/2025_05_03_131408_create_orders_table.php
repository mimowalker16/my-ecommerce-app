<?php  

use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;  

return new class extends Migration  
{  
    public function up(): void  
    {  
        Schema::create('orders', function (Blueprint $table) {  
            $table->id();  
            // Ensure users table exists before this migration runs if needed  
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Set null if user deleted, or cascade if order should be deleted too  
            $table->timestamp('order_date')->useCurrent(); // timestamp with time zone default now()  
            $table->decimal('total_amount', 10, 2);  
            $table->timestamps(); // Adds created_at and updated_at  
        });  
    }  

    public function down(): void  
    {  
        Schema::dropIfExists('orders');  
    }  
};  