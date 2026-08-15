<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\LeaveType;

class InitialDataSeeder extends Seeder
{
    /**
     * Exécute les seeds de la base de données.
     */
    public function run(): void
    {
        // 1. Insertion des départements de base
        $departments = [
            ['name' => 'Ressources Humaines', 'description' => 'Gestion du personnel et administration'],
            ['name' => 'Informatique & Tech', 'description' => 'Développement, infrastructure et support IT'],
            ['name' => 'Finance & Comptabilité', 'description' => 'Gestion financière et comptable'],
            ['name' => 'Direction Générale', 'description' => 'Pilotage stratégique de l organisation'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['name' => $dept['name']], $dept);
        }

        // 2. Insertion des types de congés réglementaires
        $leaveTypes = [
            ['name' => 'Congé Annuel', 'description' => 'Congé payé légal annuel'],
            ['name' => 'Congé Maladie', 'description' => 'Absence justifiée pour raison médicale'],
            ['name' => 'Congé Maternité / Paternité', 'description' => 'Congé lié à l arrivée d un enfant'],
            ['name' => 'Congé Sans Solde', 'description' => 'Absence non rémunérée autorisée'],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::firstOrCreate(['name' => $type['name']], $type);
        }
    }
}
