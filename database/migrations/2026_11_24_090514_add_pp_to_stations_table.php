<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            // nullable — чтобы миграция прошла на существующих данных
            // after() оставлен на случай будущего перехода на MySQL, на SQLite просто игнорируется
            $table->unsignedInteger('pp')->nullable()->after('id');
        });

        // Заполняем существующие записи порядковыми номерами
        DB::table('stations')->orderBy('id')->get()->each(function ($station, $index) {
            DB::table('stations')
                ->where('id', $station->id)
                ->update(['pp' => $index + 1]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->dropColumn('pp');
        });
    }
};
