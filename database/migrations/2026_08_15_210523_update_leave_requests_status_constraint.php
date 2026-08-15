<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Supprime l'ancienne contrainte restrictive de PostgreSQL
        DB::statement('ALTER TABLE leave_requests DROP CONSTRAINT IF EXISTS leave_requests_status_check;');

        // Ajoute la nouvelle contrainte autorisant les statuts en français et en anglais
        DB::statement("ALTER TABLE leave_requests ADD CONSTRAINT leave_requests_status_check CHECK (status IN ('en_attente', 'approuve', 'refuse', 'pending', 'approved', 'rejected'));");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE leave_requests DROP CONSTRAINT IF EXISTS leave_requests_status_check;');
    }
};
