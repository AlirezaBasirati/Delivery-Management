<?php

namespace App\Services\OrderService\Console\Commands\V1;

use App\Services\OrderService\Models\BroadcastOrder;
use App\Services\OrderService\Models\BroadcastOrderArchive;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ArchiveBroadcastOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archive:broadcast_orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        DB::beginTransaction();

        $broadcast_orders = BroadcastOrder::query()
            ->whereNotNull('assigned_at');

        $broadcast_orders->clone()
            ->chunk(50, function ($broadcast_orders) {
                BroadcastOrderArchive::query()->insert($broadcast_orders->toArray());
            });

        $broadcast_orders->clone()->delete();

        DB::commit();
    }
}
