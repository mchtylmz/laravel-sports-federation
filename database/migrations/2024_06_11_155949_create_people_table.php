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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('federation_id')->nullable()->index();
            $table->string('type')->nullable()->index();
            $table->string('photo')->nullable();
            $table->string('name');
            $table->string('surname');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('nationality')->nullable();
            $table->string('identity')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('adult', ['0', '1', '2'])->default('2')->index();
            $table->string('father_name')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable()->index();
            $table->date('registered_at')->nullable();
            $table->date('licensed_at')->nullable();
            $table->string('license_no')->nullable();
            $table->enum('status', ['active', 'passive', 'pending'])->default('active')->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
