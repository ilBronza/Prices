<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMeasurementUnitsForeignToPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('prices.models.price.table'), function (Blueprint $table) {

            $table->string('measurement_unit_id', 16)->nullable();
            $table->foreign('measurement_unit_id')
                    ->references('id')
                    ->on(config('measurementUnits.models.measurementUnit.table'));

            $table->unsignedBigInteger('quantity_from')->nullable();
            $table->unsignedBigInteger('quantity_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('prices.models.price.table'), function (Blueprint $table) {
                $table->dropForeign(['measurement_unit_id']);
                $table->dropColumn('measurement_unit_id');
                $table->dropColumn('quantity_from');
                $table->dropColumn('quantity_to');
        });
    }
}
