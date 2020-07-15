<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use YuriyMartini\Subscriptions\Traits\InteractsWithContractsBindings;

class CreateSubscriptionsCouponSubscriptionTable extends Migration
{
    use InteractsWithContractsBindings;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $coupon = static::resolveCouponContract();
        $subscription = static::resolveSubscriptionContract();

        Schema::create($this->getTable(), function (Blueprint $table) use (
            $subscription,
            $coupon
        ) {
            $table->unsignedBigInteger($coupon->getForeignKey());
            $table->unsignedBigInteger($subscription->getForeignKey());
            $table->timestamps();

            $table->primary([$coupon->getForeignKey(), $subscription->getForeignKey()], 'coupon_id_subscription_id_primary');

//            fixme: add foreign keys
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTable());
    }

    protected function getTable()
    {
        return static::resolveCouponContract()->getTable() . '_' . static::resolveSubscriptionContract()->getTable();
    }
}
