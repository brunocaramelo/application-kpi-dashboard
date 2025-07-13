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
        Schema::create('kpi_items', function (Blueprint $table) {
            $table->id();


            $table->string('titulo');
            $table->decimal('valor', 10, 2);
            $table->decimal('variacao_percentual', 10, 2);

            $table->unsignedBigInteger('kpi_type_id');

            $table->timestamps();

            $table->softDeletes();

            $table->foreign('kpi_type_id')
                  ->references('id')
                  ->on('kpi_types');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_items');
    }
};
