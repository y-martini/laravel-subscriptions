<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use YuriyMartini\Subscriptions\Enums\SubscriptionStatus;
use YuriyMartini\Subscriptions\Traits\HasContractsBindings;

class CreateSubscriptionsSubscriptionsTable extends Migration
{
    use HasContractsBindings;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $subscription = static::resolveSubscriptionContract();
        $customer = static::resolveHasSubscriptionsContract();
        $plan = static::resolvePlanContract();

        Schema::create($subscription->getTable(), function (Blueprint $table) use ($plan, $customer, $subscription) {
            $table->bigIncrements($subscription->getKeyName());
            $table->timestamps();

            $table->unsignedBigInteger($customer->getForeignKey());
            $table->unsignedBigInteger($plan->getForeignKey());
            $table->enum('status', SubscriptionStatus::values())->default(SubscriptionStatus::defaultValue());
            $table->date('start_date')->useCurrent();
            $table->date('end_date');

            $table->unique([$customer->getForeignKey(), $plan->getForeignKey()]);

            $table
                ->foreign($customer->getForeignKey())
                ->on($customer->getTable())
                ->references($customer->getKeyName());
            $table
                ->foreign($plan->getForeignKey())
                ->on($plan->getTable())
                ->references($plan->getKeyName());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(static::resolveSubscriptionContract()->getTable());
    }
}
