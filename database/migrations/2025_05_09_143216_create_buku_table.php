<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id(); //Auto-incrementing primary key (id)
            $table->string('title'); //Book title
            $table->string('author'); //Book author
            $table->text('description')->nullable(); //Book description (nullable)
            $table->string('cover')->nullable(); //Cover image path (nullable)
            $table->foreignId('category_id')->constrained('kategori')->onDelete('cascade'); //Foreign key made for referencing 'kategori' table
            $table->timestamps(); //Created at and updated at timestamps timestamps (created_at, updated_at)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku'); // Drop the 'buku' table when rolling back
    }
};