<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fundraiser_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 14, 2);
            $table->string('donor_name')->nullable();
            $table->string('donor_email')->nullable();
            $table->string('message', 1000)->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->timestamp('donated_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
