<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('prices.models.price.table'), function (Blueprint $table) {
            $table->id();

            $table->nullableMorphs('priceable');
            $table->nullableMorphs('created_by');

            $table->unsignedInteger('sequence')->nullable();

            $table->unsignedBigInteger('previous_id')->nullable();
            $table->foreign('previous_id')->references('id')->on('prices');

            $table->unsignedBigInteger('next_id')->nullable();
            $table->foreign('next_id')->references('id')->on('prices');

            $table->float('own_cost')->nullable();
            $table->float('cost')->nullable();
            $table->float('price')->nullable();
            $table->float('imposed_price')->nullable();

            $table->json('data')->nullable();
            $table->text('message')->nullable();

            $table->timestamp('calculated_at')->nullable();
            $table->boolean('calculated')->nullable();

            $table->boolean('valid')->nullable();
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();

            $table->timestamp('validated_at')->nullable();
            $table->timestamp('unvalidated_at')->nullable();


            $table->softDeletes();
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
        Schema::dropIfExists('prices');
    }
}
