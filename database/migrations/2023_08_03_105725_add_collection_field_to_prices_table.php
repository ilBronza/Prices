<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollectionFieldToPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! config('prices.enabled', false))
            return false;

        Schema::table(config('prices.models.price.table'), function (Blueprint $table)
        {
            $table->string('collection_id', 32)->nullable();
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
                $table->dropColumn('collection_id');
        });
    }
}
