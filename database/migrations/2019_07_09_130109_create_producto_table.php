<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->biginteger('idcategoria')->unsigned();
            $table->unsignedBigInteger('idcategoria');
            $table->biginteger('idtamano')->unsigned();
            $table->biginteger('idsabor')->unsigned();
            $table->string('codigo', 50)->nullable();
            $table->string('nombre', 100)->unique();
            $table->decimal('precio_venta', 11, 2);
            $table->integer('stock')->nullable();
            $table->string('descripcion', 256)->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_spanish_ci';

            $table->foreign('idcategoria')->references('id')->on('categoria')->onDelete('cascade');
            $table->foreign('idtamano')->references('id')->on('tamano');
            $table->foreign('idsabor')->references('id')->on('sabor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
