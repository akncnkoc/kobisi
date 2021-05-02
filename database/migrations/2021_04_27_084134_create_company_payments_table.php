<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyPaymentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_payments', function (Blueprint $table) {
			$table->id();
			$table->foreignId('company_id');
			$table->foreignId('company_package_id');
			$table->boolean('paid')->default(false);
			$table->dateTime('paid_date')->nullable();
			$table->integer('attempt')->default(false);
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
		Schema::dropIfExists('company_payments');
	}
}
