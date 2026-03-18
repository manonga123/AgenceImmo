<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->decimal('janvier', 10, 2)->default(0);
            $table->decimal('fevrier', 10, 2)->default(0);
            $table->decimal('mars', 10, 2)->default(0);
            $table->decimal('avril', 10, 2)->default(0);
            $table->decimal('mai', 10, 2)->default(0);
            $table->decimal('juin', 10, 2)->default(0);
            $table->decimal('juillet', 10, 2)->default(0);
            $table->decimal('aout', 10, 2)->default(0);
            $table->decimal('septembre', 10, 2)->default(0);
            $table->decimal('octobre', 10, 2)->default(0);
            $table->decimal('novembre', 10, 2)->default(0);
            $table->decimal('decembre', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('revenues');
    }
};