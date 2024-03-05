<?php

use App\Services\PlanningService\Enumerations\V1\ScheduleStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->timestamp('date');
            $table->tinyInteger('day_of_week');
            $table->foreignId('vehicle_type_id')->constrained();
            $table->foreignId('timeslot_id')->constrained();
            $table->bigInteger('capacity')->default(0);
            $table->bigInteger('reserved_capacity')->default(0);
            $table->bigInteger('used_capacity')->default(0);
            $table->bigInteger('vehicles_count')->default(0);
            $table->boolean('status')->default(ScheduleStatus::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
