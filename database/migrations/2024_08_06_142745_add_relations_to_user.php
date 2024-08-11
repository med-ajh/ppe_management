<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the foreign key columns
            $table->unsignedBigInteger('value_stream_id')->after('password');
            $table->unsignedBigInteger('department_id')->nullable()->after('value_stream_id');

            $table->foreign('value_stream_id')->references('id')->on('value_streams')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraints
            $table->dropForeign(['value_stream_id']);
            $table->dropForeign(['department_id']);

            // Drop the foreign key columns
            $table->dropColumn('value_stream_id');
            $table->dropColumn('department_id');
        });
    }
};
