<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('thumbnail')->nullable();
            $table->string('location')->nullable();
            $table->string('meeting_url')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->decimal('price', 12, 2)->default(0);
            $table->boolean('is_member_only')->default(false);
            $table->boolean('is_free')->default(true);
            $table->integer('quota')->nullable();
            $table->enum('status', ['draft','open','closed','completed'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('events'); }
};
