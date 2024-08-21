<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartmentValueStreamToCartsTable extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('value_stream_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('cost_center')->nullable();
            $table->foreign('value_stream_id')->references('id')->on('value_streams')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['value_stream_id']);
            $table->dropColumn('department_id');
            $table->dropColumn('value_stream_id');
        });
    }
}
