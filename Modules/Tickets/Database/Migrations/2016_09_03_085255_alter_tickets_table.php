<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTicketsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tickets', function (Blueprint $table) {
      $table->dropColumn('title');
      $table->dropColumn('description');
      $table->renameColumn('status_id', 'status_id');
      $table->renameColumn('assigned_to_staff_id', 'assigned_to');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    //
  }
}
