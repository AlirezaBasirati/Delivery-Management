<?php

use App\Services\FleetService\Enumerations\V1\DriverStatus;
use App\Services\FleetService\Enumerations\V1\DriverType;
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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tenant_id');
            $table->string('emergency_mobile')->nullable();
            $table->string('license_number', 10)->nullable();
            $table->boolean('status')->default(DriverStatus::Inactive->value);
            $table->boolean('is_free')->default(true);
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->integer('distance_from_next_location')->nullable();
            $table->integer('duration_to_next_location')->nullable();
            $table->enum('type', [DriverType::ON_DEMAND->value, DriverType::SCHEDULED->value])->default(DriverType::ON_DEMAND->value);
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
        Schema::dropIfExists('drivers');
    }
};
