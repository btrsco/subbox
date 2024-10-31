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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->morphs('subscriber');
            $table->foreignId('blog_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('verification_token')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['subscriber_id', 'subscriber_type', 'blog_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
