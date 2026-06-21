<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DakwahUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lombaId;
    public $status;
    public $waktu;
    public $namaPeserta;

    public function __construct($lombaId, $status, $waktu, $namaPeserta)
    {
        $this->lombaId = $lombaId;
        $this->status = $status; // 'start', 'pause', 'reset', 'sync'
        $this->waktu = $waktu;   // total detik durasi
        $this->namaPeserta = $namaPeserta;
    }

    public function broadcastOn()
    {
        return new Channel('lomba.' . $this->lombaId);
    }

    public function broadcastAs()
    {
        return 'dakwah.updated';
    }
}