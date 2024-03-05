<?php

use App\Services\OrderService\Enumerations\V1\OrderAssignmentPriority;
use App\Services\OrderService\Enumerations\V1\OrderType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->nullable();
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('last_status_id')->nullable();
            $table->double('parcel_value')->default(0);
            $table->unsignedInteger('price')->default(0);
            $table->enum('type', [OrderType::ON_DEMAND->value, OrderType::SCHEDULED->value])->default(OrderType::ON_DEMAND->value);
            $table->double('cod_amount')->default(0);
            $table->integer('package_quantity')->default(1);
            $table->unsignedInteger('schedule_id')->nullable();
            $table->unsignedInteger('driver_id')->nullable();
            $table->unsignedInteger('vehicle_id')->nullable();
            $table->integer('broadcast_count')->default(0);
            $table->integer('is_processing')->default(0);
            $table->integer('priority')->default(OrderAssignmentPriority::HIGH->value);
            $table->string('note')->nullable();
            $table->json('permissions');
            $table->timestamp('last_broadcast_at')->nullable();
            $table->timestamp('start_of_schedule')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // because of can not add increment field without primary and can not add double primary key
        DB::statement("ALTER Table orders add delivery_code INTEGER NOT NULL UNIQUE AUTO_INCREMENT after id;");
        DB::statement("ALTER Table orders AUTO_INCREMENT=100001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
