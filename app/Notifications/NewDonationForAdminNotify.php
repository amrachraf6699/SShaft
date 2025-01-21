<?php

namespace App\Notifications;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewDonationForAdminNotify extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $donation;

    public function __construct($donation)
    {
        $this->donation = $donation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'id'            =>  $this->donation->id,
            'name'          =>  $this->donation->donor->membership_no,
            'message'       =>  $this->donation->payment_ways === 'bank_transfer' ? ' تبرع مدفوع عن طريق البنك من العضو رقم' . $this->donation->donor->membership_no : ' تبرع مدفوع عن طريق البطاقة من العضو رقم' . $this->donation->donor->membership_no,
            'url'           =>  $this->donation->payment_ways === 'bank_transfer' ? route('dashboard.verification-donations.edit', $this->donation->id) : route('donation-invoice.show', $this->donation->donation_code),
            'image'         =>  Str::limit($this->donation->donor->membership_no, 1, ''),
            'created_at'    =>  $this->donation->created_at->format('d M, Y h:i a'),
        ];
    }
}
