<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donors', function (Blueprint $table) {
            $table->boolean('is_walk_in')->default(false)->after('assigned_hospital_id');
        });

        DB::table('donors')
            ->whereNull(DB::raw("json_extract(data, '$.surname')"))
            ->update(['is_walk_in' => true]);
    }

    public function down(): void
    {
        Schema::table('donors', function (Blueprint $table) {
            $table->dropColumn('is_walk_in');
        });
    }
};
