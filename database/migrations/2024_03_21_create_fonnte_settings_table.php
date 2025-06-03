<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fonnte_settings', function (Blueprint $table) {
            $table->id();
            $table->string('api_key');
            $table->string('admin_number');
            $table->string('base_url')->default('https://api.fonnte.com/send');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fonnte_settings');
    }
}; 