<?php

use App\Services\FleetService\Enumerations\V1\DriverVehicleStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('driver_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->boolean('status')->default(DriverVehicleStatus::Active->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_vehicles');
    }
};
