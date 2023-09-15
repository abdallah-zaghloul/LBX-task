<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Modules\Employee\Enums\GenderEnum;
use Modules\Employee\Enums\NamePrefixEnum;
use Modules\Employee\Enums\RegionEnum;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table) {
            $table->increments('id');
            $table->string('user_name')->unique();
            $table->enum('name_prefix', NamePrefixEnum::values());
            $table->string('first_name');
            $table->string('middle_initial');
            $table->string('last_name');
            $table->enum('gender', GenderEnum::values());
            $table->string('email')->unique();
            $table->date('date_of_birth');
            $table->time('time_of_birth');
            $table->decimal('age_in_years',5, 2);
            $table->date('date_of_joining');
            $table->decimal('age_in_company',5, 2);
            $table->string('phone_no',16);
            $table->string('place_name');
            $table->string('country');
            $table->string('city');
            $table->string('zip',16);
            $table->string('region',16);
//            $table->enum('region', RegionEnum::values());
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
		Schema::drop('employees');
	}
};
