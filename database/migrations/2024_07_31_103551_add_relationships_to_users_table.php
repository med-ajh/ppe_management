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
            $table->unsignedBigInteger('department_id')->after('password');
            $table->unsignedBigInteger('cost_center_id')->nullable()->after('department_id');

            // Add the foreign key constraints
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('cost_center_id')->references('id')->on('cost_centers')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraints
            $table->dropForeign(['department_id']);
            $table->dropForeign(['cost_center_id']);

            // Drop the foreign key columns
            $table->dropColumn('department_id');
            $table->dropColumn('cost_center_id');
        });
    }
};
