<?php

namespace App\Repositories;

use App\Libs\ValueUtil;
use App\Models\Maintenance;
use Exception;
use Illuminate\Support\Facades\Log;

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
        try {
            $data = [
                'mode' => $mode,
                'body' => $body,
            ];
            $maintenance = Maintenance::query()
                ->where([
                    ['del_flg', ValueUtil::constToValue('common.del_flg.VALID')],
                ])
                ->first();
            if ($maintenance) {
                $maintenance->fill($data);
                $result = $maintenance->save();
            } else {
                $result = Maintenance::create($data);
            }

            return $result;
        } catch (Exception $e) {
            Log::error($e);

            return false;
        }
    }

    /**
     * Get Maintenance
     *
     * @return Maintenance
     */
    public function getMaintenance() {
        $query = Maintenance::query()
            ->where([
                ['del_flg', ValueUtil::constToValue('common.del_flg.VALID')],
            ]);

        return $query->first();
    }
}
