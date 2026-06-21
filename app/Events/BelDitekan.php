<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Perhatikan ada tambahan "implements ShouldBroadcastNow"
class BelDitekan implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lombaId;
    public $timId;
    public $namaTim;

    /**
     * Data apa saja yang mau dikirim lewat sinyal ini?
     */
    public function __construct($lombaId, $timId, $namaTim)
    {
        $this->lombaId = $lombaId;
        $this->timId = $timId;
        $this->namaTim = $namaTim;
    }

    /**
     * Di "saluran" mana sinyal ini akan disiarkan?
     */
    public function broadcastOn(): array
    {
        // Kita membuat saluran khusus untuk lomba ini saja, biar tidak bocor ke lomba lain
        return [
            new Channel('lomba.' . $this->lombaId),
        ];
    }
    
    /**
     * Nama event yang akan ditangkap oleh Javascript di tampilan
     */
    public function broadcastAs(): string
    {
        return 'bel.ditekan';
    }
}