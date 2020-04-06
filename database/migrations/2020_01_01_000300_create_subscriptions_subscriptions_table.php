<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use YuriyMartini\Subscriptions\Models\Subscription;
use YuriyMartini\Subscriptions\Traits\UsesTables;

class CreateSubscriptionsSubscriptionsTable extends Migration
{
    use UsesTables;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::getSubscriptionsTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('plan_id');
            $table->enum('status', [Subscription::STATUS_ACTIVE, Subscription::STATUS_UNPAID, Subscription::STATUS_CANCELLED])
                ->default(Subscription::DEFAULT_STATUS);
            $table->date('start_date')->useCurrent();
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'plan_id']);

            $table
                ->foreign('user_id')
                ->on(static::getUsersTable())
                ->references('id');

            $table
                ->foreign('plan_id')
                ->on(static::getPlansTable())
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
        Schema::dropIfExists(static::getSubscriptionsTable());
    }
}
