<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Repositories\{GroupRepository, UserRepository};
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class UserController extends Controller
{
    private UserRepository $userRepository;

    private GroupRepository $groupRepository;

    public function __construct(UserRepository $userRepository, GroupRepository $groupRepository) {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $params = $request->only('user_name', 'started_date_from', 'started_date_to');

        $users = $this->pagination($this->userRepository->search($params));

        return view('screens.user.list', compact('users', 'params'));
    }

    /**
     * Handle export csv
     * @param Request $request
     */
    public function exportCSV(Request $request) {
        try {
            $params = $request->only('user_name', 'started_date_from', 'started_date_to');

            $users = $this->userRepository->search($params)->get();

            $mappingUsers = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'group_id' => $user->group_id,
                    'group_name' => $user->group_name ?? '', // Use null coalescing operator to handle null case
                    'started_date' => $user->started_date,
                    'position' => $user->position_name,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ];
            })->toArray();

            return Excel::download(new UserExport([$mappingUsers]), 'users.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $groupNameList = $this->groupRepository->searchGroupName();

        return view('screens.user.addEditDelete', compact('groupNameList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id) {
        $user = $this->userRepository->searchById($id);

        return view('screens.user.addEditDelete', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
    }
}
