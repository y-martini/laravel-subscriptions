<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use YuriyMartini\Subscriptions\Enums\BillingInterval;
use YuriyMartini\Subscriptions\Traits\InteractsWithContractsBindings;

class CreateSubscriptionsPlansTable extends Migration
{
    use InteractsWithContractsBindings;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $service = static::resolveServiceContract();
        $plan = static::resolvePlanContract();

        Schema::create($plan->getTable(), function (Blueprint $table) use (
            $plan,
            $service
        ) {
            $table->bigIncrements($plan->getKeyName());
            $table->timestamps();

            $table->unsignedBigInteger($service->getForeignKey());
            $table->string('key');
            $table->string('name');
            $table->unsignedDecimal('price');
            $table->enum('billing_interval_unit', BillingInterval::values())->default(BillingInterval::defaultValue());
            $table->unsignedSmallInteger('billing_interval_value')->default(1);

            $table->unique([$service->getForeignKey(), 'key']);

            $table
                ->foreign($service->getForeignKey())
                ->on($service->getTable())
                ->references($service->getKeyName());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(static::resolvePlanContract()->getTable());
    }
}
