<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Jika tabel belum ada, buat baru
        if (!Schema::hasTable('journals')) {
            Schema::create('journals', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('author');
                $table->string('file_path');
                $table->string('file_name');
                $table->string('file_size')->nullable();
                $table->string('file_type')->nullable();
                $table->text('abstract')->nullable();
                $table->string('category')->nullable();
                $table->string('volume')->nullable();
                $table->year('year')->nullable();
                $table->unsignedInteger('download_count')->default(0);
                $table->boolean('is_published')->default(true);
                $table->enum('access', ['free', 'premium'])->default('free');
                $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }

        // Jika tabel sudah ada, tambahkan kolom access jika belum ada
        if (Schema::hasTable('journals') && !Schema::hasColumn('journals', 'access')) {
            Schema::table('journals', function (Blueprint $table) {
                $table->enum('access', ['free', 'premium'])->default('free')->after('is_published');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};