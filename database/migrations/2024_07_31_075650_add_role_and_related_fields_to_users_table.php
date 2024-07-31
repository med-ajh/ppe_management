<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleAndRelatedFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('employee'); // Role column
            $table->string('department')->nullable(); // Department attribute
            $table->string('cost_center')->nullable(); // Cost Center for Manager
            $table->unsignedBigInteger('manager_id')->nullable(); // Manager reference

            // Foreign key constraint for manager_id
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn(['role', 'department', 'cost_center', 'manager_id']);
        });
    }
}
