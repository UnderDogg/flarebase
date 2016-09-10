<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToTicketsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tickets', function (Blueprint $table) {
      $table->string('ticket_number')->after('id');
      $table->integer('dept_id')->after('ticket_number');
      $table->integer('team_id')->after('dept_id');
      $table->integer('priority_id')->after('team_id');
      $table->integer('source_id')->after('status_id');
      $table->integer('reported_by_id')->after('source_id');
      $table->integer('updated_by_id')->after('reported_by_id');
      $table->integer('sla_id')->after('assigned_to');
      $table->integer('help_topic_id')->after('sla_id');
      $table->boolean('hashtml')->after('help_topic_id');
      $table->boolean('isdeleted')->after('hashtml');
      $table->boolean('isclosed')->after('isdeleted');
      $table->boolean('isreopened')->after('isclosed');
      $table->timestamp('reopened_at')->after('isreopened');
      $table->boolean('isanswered')->after('reopened_at');
      $table->boolean('is_transferred')->after('isanswered');
      $table->timestamp('transferred_at')->after('is_transferred');
      $table->timestamp('closed_at')->after('transferred_at');
      $table->timestamp('last_message_at')->after('closed_at');
      $table->timestamp('last_response_at')->after('last_message_at');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('tickets', function (Blueprint $table) {
      //
    });
  }
}
