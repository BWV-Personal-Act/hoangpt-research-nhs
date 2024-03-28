<?php

namespace App\Http\Middleware;

use App\Libs\ValueUtil;
use App\Repositories\MaintenanceRepository;
use Closure;

class CheckMaintenanceMode
{
    public function __construct(
        private MaintenanceRepository $maintenanceRepository,
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $maintenance = $this->maintenanceRepository->getMaintenance();
        $ip = $request->header('x-forwarded-for');
        if (
            $maintenance
            && $maintenance->mode == ValueUtil::constToValue('maintenance.mode.DOWN')
            && ! $this->isValidIp($ip)
        ) {
            abort(503, $maintenance->body);
        }

        return $next($request);
    }

    /**
     * Check whitelist ip
     *
     * @param string $ip
     * @return bool
     */
    protected function isValidIp($ip) {
        return in_array($ip, ValueUtil::get('maintenance.ip_whitelist'));
    }
}
