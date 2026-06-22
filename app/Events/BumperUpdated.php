<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BumperUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $status;

    public function __construct($status)
    {
        $this->status = $status; // 'on' atau 'off'
    }

    // Menggunakan saluran global agar semua layar menangkap sinyal ini
    public function broadcastOn()
    {
        return new Channel('layar.global');
    }

    public function broadcastAs()
    {
        return 'bumper.updated';
    }
}