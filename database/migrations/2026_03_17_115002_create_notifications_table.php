<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('idnotification');
            $table->foreignId('id_destinataire')->nullable()
                  ->constrained('users', 'id')
                  ->onDelete('cascade');
            $table->foreignId('id_emetteur')->nullable()
                  ->constrained('users', 'id')
                  ->onDelete('cascade');
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->enum('type', [
                'inscription',
                'new_produits',
                'new_rendez_vous',
                'rendez_vous_confirme',
                'rendez_vous_rejete'
            ]);
            $table->timestamp('time')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
