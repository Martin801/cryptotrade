<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitcoinBotsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'bitcoin_bots';

    /**
     * Run the migrations.
     * @table bitcoin_bots
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_id')->default('0');
            $table->integer('user_id');
            $table->integer('exchange_id');
            $table->string('type');
            $table->string('currency');
            $table->string('currency_to_spend_earn');
            $table->string('qty');
            $table->string('amount');
            $table->string('qty_limit');
            $table->string('amount_limit');
            $table->string('qty_stop_loss_one');
            $table->string('amount_stop_loss_one');
            $table->string('qty_stop_loss_two');
            $table->string('amount_stop_loss_two');
            $table->string('status')->default('Pending');
            $table->date('created_date');
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
