<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('ikon')->nullable()->comment('Emoji atau path gambar ikon');
            $table->text('deskripsi_singkat');
            $table->longText('deskripsi_lengkap')->nullable();
            $table->enum('kategori', ['Darurat', 'Rawat Inap', 'Poliklinik', 'Lainnya'])->default('Poliklinik');
            $table->integer('urutan')->default(0);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('gambar')->nullable()->comment('Path gambar banner layanan');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
