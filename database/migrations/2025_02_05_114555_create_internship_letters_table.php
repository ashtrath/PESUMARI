<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('internship_letters', function (Blueprint $table) {
            $table->id();
            $table->char('student_id', 9);
            $table->foreign('student_id')->references('nim')->on('students')->cascadeOnDelete();
            $table->foreignId('kaprodi_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('officer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('letter_path');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('submission_date')->useCurrent();
            $table->timestamp('approval_date')->nullable();
            $table->timestamp('processing_date')->nullable();

            $table->index(['student_id', 'kaprodi_id', 'officer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_letters');
    }
};
