<?php

namespace YuriyMartini\Subscriptions\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use YuriyMartini\Subscriptions\Contracts\ExpiredNotification as ExpiredNotificationContract;
use YuriyMartini\Subscriptions\Contracts\HasSubscriptions;
use YuriyMartini\Subscriptions\Contracts\Subscription;

class ExpiredNotification extends Notification implements ExpiredNotificationContract, ShouldQueue
{
    use Queueable;

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
            ->subject(Lang::get('subscriptions::notifications.expired.subject'))
            ->greeting(Lang::get('subscriptions::notifications.expired.greeting'))
            ->line(Lang::get('subscriptions::notifications.expired.intro'))
            ->line(Lang::get('subscriptions::notifications.expired.body'));

        if ($url = $notifiable->getSubscriptionUrl($this->subscription)){
            $message
                ->action(Lang::get('subscriptions::notifications.expired.action_text'), $url)
                ->line(Lang::get('subscriptions::notifications.expired.outro'));
        }

        return $message->salutation(Lang::get('subscriptions::notifications.expired.salutation', ['name' => Config::get('app.name')]));
    }
}
