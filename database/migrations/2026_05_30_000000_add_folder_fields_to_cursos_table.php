<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFolderFieldsToCursosTable extends Migration
{
    public function up()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->string('numero_seminario', 20)->nullable()->after('titulo');
            $table->string('investimento', 100)->nullable()->after('local');
            $table->string('carga_horaria', 50)->nullable()->after('investimento');
            $table->text('publico_alvo')->nullable()->after('carga_horaria');
            $table->json('programacao')->nullable()->after('publico_alvo');
            $table->json('folder_palestrantes')->nullable()->after('programacao');
        });
    }

    public function down()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn(['numero_seminario', 'investimento', 'carga_horaria', 'publico_alvo', 'programacao', 'folder_palestrantes']);
        });
    }
}
