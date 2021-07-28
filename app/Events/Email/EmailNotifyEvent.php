<?php

namespace App\Events\Email;

use App\Services\Contracts\DTOs\Question\QuestionInfoDTO;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailNotifyEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var $questionCreateDTO
     */
    public $dataDTO;

    /**
     * Create a new event instance.
     *
     * @param QuestionInfoDTO $questionCreateDTO
     */
    public function __construct( $dataDTO)
    {
        $this->dataDTO = $dataDTO;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
