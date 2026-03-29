<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        DB::statement("
            ALTER TABLE payments 
            MODIFY COLUMN status 
            ENUM('pending','waiting','paid','failed','rejected','expired') 
            DEFAULT 'pending'
        ");

        // Tambah kolom jika belum ada
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'sender_name'))
                $table->string('sender_name')->nullable()->after('notes');
            if (!Schema::hasColumn('payments', 'transfer_date'))
                $table->date('transfer_date')->nullable()->after('sender_name');
            if (!Schema::hasColumn('payments', 'proof_path'))
                $table->string('proof_path')->nullable()->after('transfer_date');
        });
    }

    public function down(): void {
        DB::statement("
            ALTER TABLE payments 
            MODIFY COLUMN status 
            ENUM('pending','paid','failed','expired') 
            DEFAULT 'pending'
        ");
    }
};