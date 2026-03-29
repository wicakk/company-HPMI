<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            // $table->enum('type', ['article','event','material'])->default('article');
            $table->text('type')->change();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('categories'); }
};
