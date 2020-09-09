<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Pusher\Pusher;

class ExchangeRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    protected $receiver_id, $request_notifications;
    public function __construct($receiver_id, $request_notifications)
    {
        $this->receiver_id=$receiver_id;
        $this->request_notifications=$request_notifications;
        $pusher = new Pusher('13dc91256b26300c36f3', '09628386994867dfd90f', '1066164', array('cluster' => 'ap2'));
        $pusher->trigger("exchange_requests_notification.".$this->receiver_id, "exchange.requested",$this->request_notifications);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ;
    }
}
