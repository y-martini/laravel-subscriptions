<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use YuriyMartini\Subscriptions\Enums\DiscountType;
use YuriyMartini\Subscriptions\Traits\InteractsWithContractsBindings;

class CreateSubscriptionsCouponsTable extends Migration
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

        Schema::create($coupon->getTable(), function (Blueprint $table) use ($coupon) {
            $table->bigIncrements($coupon->getKeyName());
            $table->timestamps();

            $table->string('name');
            $table->enum('type', DiscountType::values());
            $table->unsignedDecimal('value');
            $table->boolean('is_recurrent')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(static::resolveCouponContract()->getTable());
    }
}
