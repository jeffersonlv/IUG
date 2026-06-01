<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddSlugToCursosTable extends Migration
{
    public function up()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('titulo');
        });

        // Popula slugs para cursos existentes
        DB::table('cursos')->orderBy('id')->each(function ($curso) {
            $base = Str::slug($curso->titulo . '-' . $curso->id, '-');
            $str  = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $base);
            $str  = preg_replace('/[^a-zA-Z0-9\s_-]/', '', $str);
            $str  = trim(preg_replace('/[\s_-]+/', '_', $str), '_');
            $slug = strtolower($str);
            DB::table('cursos')->where('id', $curso->id)->update(['slug' => $slug]);
        });

        // Torna NOT NULL e adiciona índice único via SQL direto (sem doctrine/dbal)
        DB::statement('ALTER TABLE cursos MODIFY COLUMN slug VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE cursos ADD UNIQUE INDEX cursos_slug_unique (slug)');
    }

    public function down()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropUnique('cursos_slug_unique');
            $table->dropColumn('slug');
        });
    }
}
