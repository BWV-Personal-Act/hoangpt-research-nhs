<?php

namespace App\Http\Controllers;

use App\Imports\GroupImport;
use App\Libs\ValueUtil;
use App\Repositories\GroupRepository;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class GroupController extends Controller
{
    private GroupRepository $groupRepository;

    private AuthService $authService;

    public function __construct(GroupRepository $groupRepository, AuthService $authService) {
        $this->groupRepository = $groupRepository;
        $this->authService = $authService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $loginUser = auth()->user();

        if ($loginUser->position_id !== ValueUtil::constToValue('common.positions.DIRECTOR')) {
            return $this->authService->handleLogout();
        }

        $groups = $this->pagination($this->groupRepository->search());

        return view('screens.group.list', compact('groups'));
    }

    /**
     * Handle import csv files
     * @param Request $request
     */
    public function handleImportCSV(Request $request) {
        try {
            Excel::import(new GroupImport(), $request->file);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->response], 400);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
