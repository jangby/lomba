<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StateDiupdate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lombaId;
    public $sesiState;
    public $amplopId;

    public function __construct($lombaId, $sesiState, $amplopId = null)
    {
        $this->lombaId = $lombaId;
        $this->sesiState = $sesiState;
        $this->amplopId = $amplopId;
    }

    public function broadcastOn(): array
    {
        return [new Channel('lomba.' . $this->lombaId)];
    }

    public function broadcastAs(): string
    {
        return 'state.diupdate';
    }
}