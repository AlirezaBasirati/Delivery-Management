<?php

use App\Services\FleetService\Enumerations\V1\VehicleStatus;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedTinyInteger('type_id');
            $table->unsignedTinyInteger('container_type')->nullable();
            $table->unsignedSmallInteger('container_height')->nullable();
            $table->unsignedSmallInteger('container_width')->nullable();
            $table->unsignedSmallInteger('container_length')->nullable();
            $table->unsignedSmallInteger('capacity')->nullable();
            $table->string('plate_number')->unique();
            $table->string('chassis_number');
            $table->integer('construction_year');
            $table->double('fuel_consumption_rate')->nullable();
            $table->timestamp('insurance_expire_date');
            $table->boolean('status')->default(VehicleStatus::Active->value);
            $table->softDeletes();
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
        Schema::dropIfExists('vehicles');
    }
};
