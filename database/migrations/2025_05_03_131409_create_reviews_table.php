<?php  

use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;  
use Illuminate\Support\Facades\DB; // Import DB facade for raw SQL  

return new class extends Migration  
{  
    public function up(): void  
    {  
        Schema::create('reviews', function (Blueprint $table) {  
            $table->id();  
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');  
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');  
            $table->integer('rating');  
            $table->text('comment')->nullable();  
            $table->timestamp('review_date')->useCurrent();  
            $table->timestamps();  
        });  

        // Add CHECK constraint using raw SQL (adjust SQL for your specific DB if not MySQL/PostgreSQL)  
        // For PostgreSQL:  
        // DB::statement('ALTER TABLE reviews ADD CONSTRAINT reviews_rating_check CHECK (rating >= 1 AND rating <= 5)');  
        // For MySQL 8.0.16+ :  
         DB::statement('ALTER TABLE reviews ADD CONSTRAINT reviews_rating_check CHECK (rating >= 1 AND rating <= 5)');  
        // For older MySQL or MariaDB, CHECK constraints are parsed but not enforced. Consider application-level validation.  

    }  

    public function down(): void  
    {  
         // Drop constraint before table (syntax might vary slightly by DB)  
        // Schema::table('reviews', function (Blueprint $table) {  
        //     $table->dropCheck('reviews_rating_check'); // May require doctrine/dbal  
        // });  
        Schema::dropIfExists('reviews');  
    }  
};  