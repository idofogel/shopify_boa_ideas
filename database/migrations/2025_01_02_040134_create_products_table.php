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
            // $table->id();
            // $table->unsignedBigInteger('shopify_id');
            // $table->string('title');
            // $table->text('description');
            // $table->string('handle');
            // $table->enum('status', ['ACTIVE', 'ARCHIVED', 'DRAFT'])->default('DRAFT');
            // $table->integer('max_variant_compare');
            // $table->integer('min_variant_compare');
            
            // $table->unsignedBigInteger('collection_id'); 
            // $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
            $table->id();
            $table->string('shopify_id');
            $table->string('title');
            $table->text('description');
            $table->string('handle');
            $table->enum('status', ['ACTIVE', 'ARCHIVED', 'DRAFT'])->default('DRAFT');
            $table->float('max_variant_compare');
            $table->float('min_variant_compare');
            // $table->timestamps();
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
