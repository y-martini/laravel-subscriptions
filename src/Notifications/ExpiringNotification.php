<?php

namespace YuriyMartini\Subscriptions\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use YuriyMartini\Subscriptions\Contracts\ExpiringNotification as ExpiringNotificationContract;
use YuriyMartini\Subscriptions\Contracts\HasSubscriptions;
use YuriyMartini\Subscriptions\Contracts\Subscription;

class ExpiringNotification extends Notification implements ExpiringNotificationContract
{
    /**
     * @var Subscription
     */
    protected $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  HasSubscriptions  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject(Lang::get('subscriptions::notifications.expiring.subject'))
            ->greeting(Lang::get('subscriptions::notifications.expiring.greeting'))
            ->line(Lang::get('subscriptions::notifications.expiring.intro'))
            ->line(Lang::get('subscriptions::notifications.expiring.body'));

        if ($url = $notifiable->getSubscriptionUrl($this->subscription)){
            $message
                ->action(Lang::get('subscriptions::notifications.expiring.action_text'), $url)
                ->line(Lang::get('subscriptions::notifications.expiring.outro'));
        }

        return $message->salutation(Lang::get('subscriptions::notifications.expiring.salutation', ['name' => Config::get('app.name')]));
    }
}
