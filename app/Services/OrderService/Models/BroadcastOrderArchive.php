<?php

namespace App\Services\OrderService\Models;

//use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $order_id
 * @property string $driver_id
 * @property string $vehicle_id
 * @property integer $broadcast_count
 * @property integer $priority
 * @property string $assigned_at
 */
class BroadcastOrderArchive extends Model
{
//    protected $connection = 'mongodb';
//    protected $collection = 'broadcast_order_archives';
    protected $table = 'broadcast_order_archives';

    protected $fillable = [
        'id',
        'order_id',
        'driver_id',
        'vehicle_id',
        'broadcast_count',
        'priority',
        'assigned_at',
        'created_at',
        'updated_at',
    ];
}
