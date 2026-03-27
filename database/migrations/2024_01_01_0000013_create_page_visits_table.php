<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('page_url', 500);
            $table->string('page_title', 255)->nullable();
            $table->string('page_type', 50)->default('general'); // general, article, event, category
            $table->unsignedBigInteger('reference_id')->nullable(); // id artikel/event jika ada
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_type', 20)->default('desktop'); // mobile, desktop, tablet
            $table->string('browser', 50)->nullable();
            $table->string('os', 50)->nullable();
            $table->string('referrer', 500)->nullable();
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // jika user login
            $table->string('session_id', 100)->nullable();
            $table->unsignedInteger('duration_seconds')->default(0); // durasi di halaman
            $table->boolean('is_bounce')->default(false);
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->timestamps();

            $table->index(['created_at']);
            $table->index(['page_type', 'created_at']);
            $table->index(['ip_address', 'session_id']);
            $table->index(['device_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_visits');
    }
};
