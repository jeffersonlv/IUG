<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCnpjToEmpresasTable extends Migration
{
    public function up()
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->string('cnpj')->nullable()->after('nome');
        });
    }

    public function down()
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn('cnpj');
        });
    }
}
