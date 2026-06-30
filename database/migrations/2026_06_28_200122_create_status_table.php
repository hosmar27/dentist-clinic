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
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('status_name');
            $table->timestamps();
        });

        DB::table('status')->insert([
            ['status_name' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
            ['status_name' => 'Confirmed', 'created_at' => now(), 'updated_at' => now()],
            ['status_name' => 'Completed', 'created_at' => now(), 'updated_at' => now()],
            ['status_name' => 'Cancelled', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status');
    }
};
