<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            $table->string('donor_type');
            $table->string('id_number')->nullable();
            $table->string('full_name');
            $table->string('email');
            $table->string('contact_number')->nullable();
            $table->foreignId('assigned_hospital_id')->nullable()->constrained('hospitals')->nullOnDelete();
            $table->json('data');
            $table->string('status')->default('registered');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
