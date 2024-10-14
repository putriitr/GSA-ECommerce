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
        Schema::create('t_p_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_users')->onDelete('cascade');
            $table->foreignId('order_id')->constrained('t_orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('t_product')->onDelete('cascade');
            $table->tinyInteger('rating'); // Rating between 1 and 5
            $table->text('comment');        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_p_reviews');
    }
};
