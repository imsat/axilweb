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
        Schema::create('pre_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('total', 10, 2)->nullable();
            $table->enum('status', ['pending', 'confirmed', 'fulfilled', 'canceled'])->default('pending');
            $table->text('delivery_address')->nullable();
            $table->date('delivery_date')->nullable();
            $table->foreignId('deleted_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }
//    protected $fillable = ['user_id', 'order_id', 'status', 'total', 'delivery_date'];
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_orders');
    }
};
