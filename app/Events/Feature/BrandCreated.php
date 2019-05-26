<?php

namespace App\Events\Feature;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Models\Feature\Brand;

class BrandCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $brand;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        auth()->loginUsingId( \App\User::first()->id );
        $brand = factory(Brand::class)->create();
        
        $this->brand = [
            'id'                => $brand->id,
            'link'              => "/api/v1/brand/{$brand->id}",
            'logo'              => $brand->logo,
            'name'              => $brand->name,
            'description'       => $brand->description,
            'create_time'       => $brand->getOriginal('created_at'),
            'last_update_time'  => $brand->getOriginal('updated_at'),
            'categories'        => []
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // dd( 'brand.'.$this->brand->id );
        return new PrivateChannel('brand');

        // return new Channel('newTask');
    }

    public function broadcastAs(){
        return 'task-created';
    }
}
