<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitcoinRobotTradessTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'bitcoin_robot_tradess';

    /**
     * Run the migrations.
     * @table bitcoin_robot_tradess
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('robot_id');
            $table->integer('bot_id')->default('0');
            $table->integer('user_id');
            $table->integer('exchange_id');
            $table->string('market');
            $table->string('type_of_trade');
            $table->string('volume');
            $table->string('price');
            $table->string('pl_amount');
            $table->text('result')->nullable()->default(null);
            $table->string('type');
            $table->timestamp('datetime')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
