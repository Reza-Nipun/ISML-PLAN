<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoTnasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_tnas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('po_id');
            $table->unsignedBigInteger('tna_id');
            $table->unsignedBigInteger('tna_term_id');
            $table->date('plan_tna_date');
            $table->string('custom_plan_tna_days')->nullable();
            $table->string('custom_plan_tna_days_remarks')->nullable();
            $table->date('actual_tna_date')->nullable();
            $table->integer('difference_between_plan_actual_date')->default(0);
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('po_id')->references('id')->on('pos');
            $table->foreign('tna_id')->references('id')->on('tnas');
            $table->foreign('tna_term_id')->references('id')->on('tna_terms');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('po_tnas');
    }
}
