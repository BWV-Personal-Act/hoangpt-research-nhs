<?php

namespace App\Console\Commands;

use App\Libs\{ConfigUtil, ValueUtil};
use App\Repositories\MaintenanceRepository;
use Illuminate\Console\Command;

class ChangeMaintenanceMode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:change-maintenance-mode {mode} {bodyEndTime?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change maintenance mode';

    private MaintenanceRepository $maintenanceRepository;

    /**
     * Create a new command instance.
     *
     * @param MaintenanceRepository $maintenanceRepository
     * @return void
     */
    public function __construct(
        MaintenanceRepository $maintenanceRepository,
    ) {
        parent::__construct();
        $this->maintenanceRepository = $maintenanceRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $mode = (int) $this->argument('mode');
        $endTime = $this->argument('bodyEndTime');

        if (! array_key_exists($mode, ValueUtil::getList('maintenance.mode'))) {
            return false;
        }
        $body = null;
        if (isset($endTime)) {
            $body = ConfigUtil::getMessage('maintenance_body', [$endTime]);
        }
        if (! $this->maintenanceRepository->updateMaintenance($mode, $body)) {
            return false;
        }

        return true;
    }
}
