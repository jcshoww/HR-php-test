<?php

namespace App\Notifications;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderFinished extends Notification
{
    use Queueable;

    private $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Заказ №' . $this->order->id . ' завершен')
            ->line('Состав заказа:');
        $totalPrice = 0;
        if(!is_null($this->order->products)) {
            foreach($this->order->products as $product) {
                $mail->line($product->name . ': цена за единицу - ' . $product->price . ' , количество ' . $product->pivot->quantity);
                $totalPrice += ($product->price * $product->pivot->quantity);
            }
        }
        $mail->line('Стоимость заказа: ' . $totalPrice);
        $mail->action('Посмотреть заказ можно по ссылке', $this->order->edit_route);
        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
