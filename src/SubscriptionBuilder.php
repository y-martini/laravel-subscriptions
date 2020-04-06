<?php


namespace YuriyMartini\Subscriptions;


use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use YuriyMartini\Subscriptions\Contracts\Plan;
use YuriyMartini\Subscriptions\Contracts\Subscription;
use YuriyMartini\Subscriptions\Traits\UsesModels;

class SubscriptionBuilder
{
    use UsesModels;

    /**
     * The model that is subscribing.
     *
     * @var Model
     */
    protected $user;

    /**
     * The plan being subscribed to.
     *
     * @var Plan
     */
    protected $plan;

    /**
     * The date on which the billing cycle should start.
     *
     * @var DateTimeInterface|null
     */
    protected $startDate;

    /**
     * The date on which the subscription should expire.
     *
     * @var DateTimeInterface|null
     */
    protected $endDate;

    /**
     * Create a new subscription builder instance.
     *
     * @param Model $user
     * @param Plan $plan
     */
    public function __construct(Model $user, Plan $plan)
    {
        $this->user = $user;
        $this->plan = $plan;
    }

    /**
     * Change the billing cycle start date.
     *
     * @param DateTimeInterface $date
     * @return $this
     */
    public function startDate(DateTimeInterface $date)
    {
        $this->startDate = $date;

        return $this;
    }

    /**
     * Change the subscription expire date.
     *
     * @param DateTimeInterface $date
     * @return $this
     */
    public function endDate(DateTimeInterface $date)
    {
        $this->endDate = $date;

        return $this;
    }

    /**
     * Create a new subscription.
     *
     * @return Subscription
     */
    public function create()
    {
        return new (static::getSubscriptionModel())([
            'user_id' => $this->user->getKey(),
            'plan_id' => $this->plan->getKey(),
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);
    }
}
