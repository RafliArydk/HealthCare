<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chats', function (Blueprint $table): void {
            $table->dropForeign(['scan_id']);
            $table->unsignedBigInteger('scan_id')->nullable()->change();
            $table->foreign('scan_id')->references('id')->on('scans')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table): void {
            $table->dropForeign(['scan_id']);
            $table->unsignedBigInteger('scan_id')->nullable(false)->change();
            $table->foreign('scan_id')->references('id')->on('scans')->cascadeOnDelete();
        });
    }
};
