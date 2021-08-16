<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTnaTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tna_terms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tna_id');
            $table->string('tna_term');
            $table->string('days');
            $table->integer('responsible_user_type')->comment('0=Admin, 1=SD, 2=Commercial, 3=Planner, 4=Store');
            $table->integer('status')->comment('1=Active, 0=Inactive')->default(1);
            $table->timestamps();

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
        Schema::dropIfExists('tna_terms');
    }
}
