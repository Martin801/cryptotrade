<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitcoinUserPaymentTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'bitcoin_user_payment';

    /**
     * Run the migrations.
     * @table bitcoin_user_payment
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('membership_id');
            $table->integer('duration');
            $table->string('price');
            $table->string('transaction_id');
            $table->string('address_id')->nullable()->default(null);
            $table->string('status_url')->nullable()->default(null);
            $table->string('qrcode_url')->nullable()->default(null);
            $table->string('transaction_status');
            $table->longText('exchange_data');
            $table->string('payment_date');
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
