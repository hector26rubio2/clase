<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_roles', function (Blueprint $table) {
            $table->id();
            //Agregar las columnas que contendrán los datos foráneos
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('permission_id')->unsigned();
            //Hacer efectivo la relación
            $table->foreign('role_id')->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('permission_id')->references('id')
                ->on('permissions')
                ->onDelete('cascade');
            $table->timestamps();
            $table->unique(['role_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permiso_roles');
    }
};
