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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code_reference');
            $table->integer('standard_code_id')->default(1);
            $table->string('name');
            $table->decimal('price', 10, 2); 
            $table->integer('tribute_id')->constrained('tributes','id');
            $table->string('tax_rate');

            $table->integer('unit_measure_id')->constrained('unit_measures','id');
            $table->boolean('is_excluded');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
