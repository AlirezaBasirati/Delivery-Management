<?php

use App\Services\FleetService\Enumerations\V1\VehicleStatus;
use App\Services\OrderService\Enumerations\V1\OrderLocationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('order_locations', function (Blueprint $table) {
            $table->id();
            $table->uuid('order_id');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('postal_code')->nullable();
            $table->enum('type', [OrderLocationType::PICK_UP->value, OrderLocationType::DROP_OFF->value]);
            $table->timestamp('delivered_at')->nullable();
            $table->tinyInteger('sort')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('order_locations');
    }
};
