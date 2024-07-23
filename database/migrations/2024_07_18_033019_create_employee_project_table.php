<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee-project', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('project_id');
            $table->timestamps();
            $table->integer('create_by');
            $table->integer('update_by')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('employee_id')->references('id')->on('employee');
            $table->foreign('project_id')->references('id')->on('project');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee-project');
    }
};
