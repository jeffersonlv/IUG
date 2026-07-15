<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactFieldsToEmpresasTable extends Migration
{
    public function up()
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->string('telefone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->text('sobre_texto')->nullable();
            $table->string('endereco')->nullable();
            $table->string('publico_alvo')->nullable();
        });
    }

    public function down()
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn(['telefone', 'whatsapp', 'email', 'sobre_texto', 'endereco', 'publico_alvo']);
        });
    }
}
