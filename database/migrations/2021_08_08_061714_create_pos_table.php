<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique()->nullable();
            $table->string('po')->nullable();
            $table->string('destination')->nullable();
            $table->string('quality')->nullable();
            $table->string('color')->nullable();
            $table->string('style_no')->nullable();
            $table->string('style_name')->nullable();
            $table->unsignedBigInteger('buyer_id');
            $table->date('order_confirm_date')->nullable();
            $table->date('ship_date')->nullable();
            $table->integer('plan_quantity')->default(0);
            $table->integer('order_quantity')->default(0);
            $table->integer('po_type')->comment('0=Bulk, 1=Sample, 2=Size Set')->nullable();
            $table->unsignedBigInteger('plant_id');
            $table->unsignedBigInteger('uploaded_by');
            $table->date('actual_ship_date')->nullable();
            $table->integer('actual_ship_quantity')->default(0);
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('tna_id')->nullable();
            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('buyers');
            $table->foreign('plant_id')->references('id')->on('plants');
            $table->foreign('uploaded_by')->references('id')->on('users');
            $table->foreign('tna_id')->references('id')->on('tnas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos');
    }
}
