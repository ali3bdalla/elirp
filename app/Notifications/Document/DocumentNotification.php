<?php

    namespace App\Notifications\Document;

    use App\Models\Contact;
    use Lucid\Bus\UnitDispatcher;

    trait DocumentNotification
    {
        use UnitDispatcher;

        /**
         * Get the notification's delivery channels.
         *
         * @param mixed $notifiable
         * @return array
         */
        public function via(Contact $notifiable) : array
        {
//            , 'database'
            return [$notifiable->preferredNotificationChannel()];
        }
    }
