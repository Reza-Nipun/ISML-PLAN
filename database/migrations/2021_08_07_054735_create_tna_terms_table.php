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
            $table->unsignedBigInteger('responsible_user_type')->nullable();
            $table->integer('status')->comment('1=Active, 0=Inactive')->default(1);
            $table->timestamps();

            $table->foreign('tna_id')->references('id')->on('tnas');
            $table->foreign('responsible_user_type')->references('id')->on('user_types');
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
