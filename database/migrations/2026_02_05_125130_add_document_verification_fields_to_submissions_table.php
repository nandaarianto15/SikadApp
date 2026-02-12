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
        Schema::table('submissions', function (Blueprint $table) {
            $table->enum('document_status', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
            $table->text('document_rejection_reason')->nullable()->after('document_status');
            $table->unsignedBigInteger('document_verified_by')->nullable()->after('document_rejection_reason');
            $table->timestamp('document_verified_at')->nullable()->after('document_verified_by');
            
            $table->foreign('document_verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign(['document_verified_by']);
            $table->dropColumn(['document_status', 'document_rejection_reason', 'document_verified_by', 'document_verified_at']);
        });
    }
};