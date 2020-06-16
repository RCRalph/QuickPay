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
            ["id" => 1, "ISO_4217" => "USD", "name" => "United States dollar"],
            ["id" => 2, "ISO_4217" => "EUR", "name" => "European euro"],
            ["id" => 3, "ISO_4217" => "CHF", "name" => "Swiss franc"],
            ["id" => 4, "ISO_4217" => "PLN", "name" => "Polish zloty"],
            ["id" => 5, "ISO_4217" => "GBP", "name" => "Pound sterling"],
            ["id" => 6, "ISO_4217" => "CAD", "name" => "Canadian dollar"],
            ["id" => 7, "ISO_4217" => "JPY", "name" => "Japanese yen"],
            ["id" => 8, "ISO_4217" => "AUD", "name" => "Australian dollar"]
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
