<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('marketplace_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('marketplace');
            $table->string('api_key')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('account_name');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('marketplace_accounts');
    }
};
