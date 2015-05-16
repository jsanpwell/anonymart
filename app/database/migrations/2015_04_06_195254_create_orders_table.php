<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders',function($table){
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->foreign('product_id')->references('id')->on('products');
			$table->boolean('is_paid')->default(false);
			$table->boolean('is_shipped')->default(false);
			$table->boolean('is_cancelled')->default(false);
			$table->integer('quantity')->unsigned();
			$table->string('product_amount_btc');
			$table->string('balance_btc')->default('0');
			$table->string('address');
			$table->text('pgp_public')->nullable();
			$table->string('code');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
