<?php

namespace App\Repositories;

use App\Models\Maintenance;

class MaintenanceRepository extends BaseRepository
{
    public function getModel() {
        return Maintenance::class;
    }

    /**
     * Update maintenance
     *
     * @param int $mode
     * @param string $body
     * @return bool
     */
    public function updateMaintenance($mode, $body) {
    }

    /**
     * Get Maintenance
     *
     * @return Maintenance
     */
    public function getMaintenance() {
    }
}
