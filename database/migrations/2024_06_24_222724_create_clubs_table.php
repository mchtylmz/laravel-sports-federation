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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->text('federation_id')->nullable();
            $table->string('name')->index();
            $table->string('user_name');
            $table->string('user_phone')->nullable();
            $table->string('user_email')->nullable();
            $table->text('location')->nullable();
            $table->string('region')->nullable();
            $table->enum('status', ['active', 'passive'])->default('active')->index();
            $table->text('tombala_file')->nullable();
            $table->tinyInteger('selected')->default(0);
            $table->timestamp('selected_at')->nullable();
            $table->string('file_1')->nullable();
            $table->string('file_2')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
