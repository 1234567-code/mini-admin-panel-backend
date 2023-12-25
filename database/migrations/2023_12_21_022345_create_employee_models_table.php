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
        Schema::create('employee_models', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->required();
            $table->string('last_name')->required();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company_models')->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_models');
    }
};
