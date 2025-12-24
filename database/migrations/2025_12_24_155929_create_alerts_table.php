<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();

            // Short headline for the alert
            $table->string('title');

            // Detailed message body
            $table->text('message')->nullable();

            // Type/category of alert (info, warning, error, success)
            $table->string('type')->default('info');

            // Whether the alert has been read/acknowledged
            $table->boolean('is_read')->default(false);

            // Optional scheduling fields
            $table->timestamp('trigger_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();
        });
    }
};
