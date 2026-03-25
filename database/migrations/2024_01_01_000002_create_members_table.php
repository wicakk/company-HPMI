<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('member_code')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('institution')->nullable();
            $table->string('specialty')->nullable();
            // free = member gratis | premium_pending = menunggu validasi | premium = aktif premium
            $table->enum('status', ['free', 'premium_pending', 'premium', 'expired', 'suspended'])->default('free');
            $table->date('joined_at')->nullable();
            $table->date('expired_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('members'); }
};
