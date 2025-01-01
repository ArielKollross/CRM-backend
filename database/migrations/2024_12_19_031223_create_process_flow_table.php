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
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('process_columns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('process_id')
                ->constrained('processes')
                ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('document')->unique()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('process_id')
                ->constrained('processes')
                ->onDelete('cascade');

            $table->foreignId('process_column_id')
                ->constrained('process_columns')
                ->onDelete('cascade');

            $table->foreignId('customer_id')
                ->constrained('customer')
                ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('card_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')
                ->constrained('cards')
                ->onDelete('cascade');

            $table->foreignId('process_id')
                ->constrained('processes')
                ->onDelete('cascade');

            $table->foreignId('process_column_id')
                ->constrained('process_columns')
                ->onDelete('cascade');

            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_histories');
        Schema::dropIfExists('cards');
        Schema::dropIfExists('customer');
        Schema::dropIfExists('process_columns');
        Schema::dropIfExists('processes');
    }
};
