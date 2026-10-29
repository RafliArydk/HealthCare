<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scans', function (Blueprint $table): void {
            $table->string('cnn_label')->nullable()->after('type');
            $table->decimal('confidence_score', 5, 4)->nullable()->after('cnn_label');
            $table->string('model_version')->nullable()->after('confidence_score');
            $table->string('status')->default('pending')->after('model_version');
            $table->string('error_code')->nullable()->after('status');

            $table->index(['user_id', 'status']);
        });

        Schema::create('audit_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('scan_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event_type');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['event_type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');

        Schema::table('scans', function (Blueprint $table): void {
            $table->dropIndex(['user_id', 'status']);
            $table->dropColumn([
                'cnn_label',
                'confidence_score',
                'model_version',
                'status',
                'error_code',
            ]);
        });
    }
};
