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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            
            // Kolom untuk user yang login (jika ada)
            // Dibuat nullable() karena form Anda juga bisa diisi anonim
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Data dari Step 1
            $table->string('first_name');
            $table->string('last_name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->text('home_address');
            $table->string('email');
            $table->string('phone_number');

            // Data dari Step 2
            $table->string('incident_type');
            $table->date('incident_date');
            $table->string('incident_time');
            $table->string('incident_location');
            $table->text('description');
            $table->string('evidence_file_path')->nullable(); // Menyimpan path file di storage
            $table->boolean('is_anonymous')->default(false); // Menggunakan boolean (true/false)

            $table->string('status')->default('Terkirim'); // Untuk melacak progres laporan
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};