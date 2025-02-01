<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('hour', [
                '1manana',
                '2manana',
                '3manana',
                'recreoM',
                '4manana',
                '5manana',
                '6manana',
                '1tarde',
                '2tarde',
                '3tarde',
                'recreoT',
                '4tarde',
                '5tarde',
                '6tarde',
                '1tardeM',
                '2tardeM',
                '3tardeM',
                'recreoTM',
                '4tardeM',
                '5tardeM',
                '6tardeM'
            ]);
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
