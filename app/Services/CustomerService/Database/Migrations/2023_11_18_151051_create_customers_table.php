<?php

use App\Services\CustomerService\Enumerations\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tenant_id');
            $table->string('balance')->default(0);
            $table->enum('type', Type::getCaseValues())->default(Type::INDIVIDUAL->value);
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('verified_mobile')->nullable();
            $table->string('verification_code')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
