<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Modules\Employee\Enums\ExcelSheetStatusEnum;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('excel_sheets', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('path');
            $table->enum('status', ExcelSheetStatusEnum::values());
            $table->json('errors')->nullable();
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
		Schema::drop('excel_sheets');
	}
};
