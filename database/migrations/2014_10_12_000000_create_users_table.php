<?php

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
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('business_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('password')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone_number')->nullable();
            $table->boolean('profile_completed')->default(0);
            $table->string('zip_code')->nullable();
            $table->string('state')->nullable();
            $table->string('bio')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->enum('role', ['user', 'admin', 'business', 'armed_forces', 'fire_fighters'])->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->json('social_links')->default(json_encode([
                'website' => '',
                'facebook' => '',
                'twitter' => '',
                'linkedIn' => '',
                'instagram' => '',
            ]));
            $table->string('device_type')->nullable();
            $table->string('device_token')->nullable();
            $table->string('social_type')->nullable();
            $table->string('social_token')->nullable();
            $table->boolean('is_social')->nullable();
            $table->enum('is_active', [0, 1])->default(1);
            $table->boolean('notification_toggle')->default(1);
            $table->integer('category_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
