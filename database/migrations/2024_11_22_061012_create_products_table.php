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
            $table->string('name');
            $table->decimal('price', 8, 2); // Harga produk dengan 2 digit desimal
            $table->integer('stock'); // Stok produk
            $table->text('description')->nullable(); // Deskripsi produk (nullable)
            $table->string('address')->nullable(); // Alamat (nullable)
            $table->string('city')->nullable(); // Kota (nullable)
            $table->string('region')->nullable(); // Wilayah (nullable)
            $table->string('postal_code')->nullable(); // Kode pos (nullable)
            $table->date('date_info')->nullable(); // Tanggal informasi (nullable)
            $table->enum('grade', ['Grade A', 'Grade B'])->nullable(); // Grade produk (nullable)
            $table->string('file_upload')->nullable(); // Foto produk (nullable)
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
