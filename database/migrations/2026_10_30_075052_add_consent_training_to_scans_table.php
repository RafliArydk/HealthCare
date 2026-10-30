    public function up(): void
    {
        Schema::table('scans', function (Blueprint $table) {
            // Default false (tidak setuju)
            $table->boolean('consent_training')->default(false)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('scans', function (Blueprint $table) {
            $table->dropColumn('consent_training');
        });
    }