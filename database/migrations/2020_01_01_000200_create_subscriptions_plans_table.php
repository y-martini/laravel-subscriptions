<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use YuriyMartini\Subscriptions\Traits\UsesTables;

class CreateSubscriptionsPlansTable extends Migration
{
    use UsesTables;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::getPlansTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');
            $table->string('key');
            $table->string('name');
            $table->decimal('price');
            $table->enum('billing_interval_unit', ['days', 'weeks', 'months', 'years'])->default('months');
            $table->unsignedSmallInteger('billing_interval_value')->default(1);
            $table->timestamps();

            $table->unique(['service_id', 'key']);

            $table
                ->foreign('service_id')
                ->on(static::getServicesTable())
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(static::getPlansTable());
    }
}
