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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('title');                          // Judul jurnal
            $table->string('author');                         // Nama author
            $table->string('file_path');                      // Path file PDF/DOC
            $table->string('file_name');                      // Nama file asli
            $table->string('file_size')->nullable();          // Ukuran file (human readable)
            $table->string('file_type')->nullable();          // MIME type / ekstensi
            $table->text('abstract')->nullable();             // Abstrak / deskripsi singkat
            $table->string('category')->nullable();           // Kategori / topik
            $table->string('volume')->nullable();             // Volume / edisi
            $table->year('year')->nullable();                 // Tahun terbit
            $table->unsignedInteger('download_count')->default(0); // Jumlah unduhan
            $table->boolean('is_published')->default(true);  // Status publish
            $table->foreignId('uploaded_by')->nullable()
                  ->constrained('users')
                  ->nullOnDelete();                           // User yang upload
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
