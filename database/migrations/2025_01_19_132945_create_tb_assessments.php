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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->unsigned()->constrained()->onDelete('cascade');
            $table->integer('class_id')->unsigned()->constrained()->onDelete('cascade');
            $table->integer('subject_id')->unsigned()->constrained()->onDelete('cascade');
            $table->string('assessment_name');
            $table->float('score');
            $table->integer('semester');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
