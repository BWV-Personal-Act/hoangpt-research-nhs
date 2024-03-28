<?php

namespace App\Http\Controllers;

use App\Libs\{
    ConfigUtil,
    ValueUtil,
};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Handle pagination
     *
     * @param object $query
     */
    public function pagination($query) {
        $limit = ValueUtil::get('common.pagination_limit');
        $urlQuery = Arr::map(request()->query(), function ($value) {
            return $value ?? '';
        });

        return $query->paginate($limit)
            ->appends($urlQuery);
    }

    /**
     * Return a response to view PDF on browser
     *
     * @param string $content PDF string content
     * @param string $filename
     * @return mixed
     */
    public function showPDFResponse($content, $filename) {
        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename=\"{$filename}\"",
        ]);
    }
}
