<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->id(); //Auto-increment primary key (id)
            $table->string('name'); //Name of the category
            $table->timestamps(); //Created at and updated at timestamps (created_at, updated_at)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori'); // Drop the 'kategori' table when rolling back
    }
};

