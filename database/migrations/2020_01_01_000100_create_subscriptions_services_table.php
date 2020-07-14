<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use YuriyMartini\Subscriptions\Traits\HasContractsBindings;

class CreateSubscriptionsServicesTable extends Migration
{
    use HasContractsBindings;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::resolveServiceContract()->getTable(), function (Blueprint $table) {
            $table->bigIncrements(static::resolveServiceContract()->getKeyName());
            $table->timestamps();

            $table->string('key')->unique();
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(static::resolveServiceContract()->getTable());
    }
}
