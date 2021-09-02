<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddresseesMails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addressees_mails', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('addressee_id')
            ->constrained('addressees')
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->foreignId('mail_id')
            ->constrained('mails')
            ->onDelete("cascade")
            ->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addressees_mails');
    }
}
