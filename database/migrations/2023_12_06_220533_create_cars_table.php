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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string("reference")->default(uniqid());
            $table->double("latitude")->default(0);
            $table->double("longitude")->default(0);
            $table->float('speed')->default(0);
            $table->enum('status', ['active', 'inactive', 'running'])->default("active");
            $table->foreignId("user_id")->nullable()->constrained("users")->onDelete("cascade");
            $table->unsignedBigInteger('traject_id')->nullable();
            $table->foreign('traject_id')->references('id')->on('trajects')->onDelete('cascade');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
