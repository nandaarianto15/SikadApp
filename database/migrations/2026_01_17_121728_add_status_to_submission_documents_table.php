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
        Schema::table('submission_documents', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('file_size');
            $table->text('notes')->nullable()->after('status');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->after('notes');
            $table->timestamp('verified_at')->nullable()->after('verified_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submission_documents', function (Blueprint $table) {
            $table->dropColumn(['status', 'notes', 'verified_by', 'verified_at']);
        });
    }
};