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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('type')->default(\App\Enums\EventTypeEnum::event)->index();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('location')->nullable();
            $table->tinyInteger('is_national')->default(0);
            $table->date('start_date')->nullable();
            $table->time('start_time')->default('09:00:00');
            $table->date('end_date')->nullable();
            $table->time('end_time')->default('18:00:00');
            $table->text('end_notes')->nullable();
            $table->text('end_notes2')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
