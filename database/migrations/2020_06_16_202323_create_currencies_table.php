<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('ISO_4217', 3);
            $table->string('name');
        });

        DB::table("currencies")->insert([
            ["ISO_4217" => "USD", "name" => "United States Dollar"],
            ["ISO_4217" => "EUR", "name" => "European Euro"],
            ["ISO_4217" => "CHF", "name" => "Swiss Franc"],
            ["ISO_4217" => "PLN", "name" => "Polish Zloty"],
            ["ISO_4217" => "GBP", "name" => "Pound Sterling"],
            ["ISO_4217" => "CAD", "name" => "Canadian Dollar"],
            ["ISO_4217" => "JPY", "name" => "Japanese Yen"],
            ["ISO_4217" => "AUD", "name" => "Australian Dollar"]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
