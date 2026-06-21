<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SkorDiupdate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lombaId;
    public $timId;
    public $skorBaru;

    public function __construct($lombaId, $timId, $skorBaru)
    {
        $this->lombaId = $lombaId;
        $this->timId = $timId;
        $this->skorBaru = $skorBaru;
    }

    public function broadcastOn(): array
    {
        return [new Channel('lomba.' . $this->lombaId)];
    }

    public function broadcastAs(): string
    {
        return 'skor.diupdate';
    }
}