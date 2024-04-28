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
        Schema::create('transferences', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_payer')->unsigned();
            $table->bigInteger('id_payee')->unsigned();
            $table->float('value');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_payer')
                ->references('id')
                ->on('accounts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_payee')
                ->references('id')
                ->on('accounts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferences');
    }
};
