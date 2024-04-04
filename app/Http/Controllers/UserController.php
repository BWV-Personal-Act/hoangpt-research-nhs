<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Libs\{ConfigUtil, EncryptUtil, ValueUtil};
use App\Repositories\{GroupRepository, UserRepository};
use App\Requests\User\{CreateRequest, UpdateRequest};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function store(CreateRequest $request) {
        $fields = [
            'name',
            'email',
            'group_id',
            'started_date',
            'position_id',
            'password',
        ];

        $isExistEmail = $this->userRepository->checkExistsEmail($request->only('email'));

        if ($isExistEmail) {
            return back()->withInput()->withErrors(ConfigUtil::getMessage('EBT019'));
        }

        if (! $this->userRepository->create($request->only($fields))) {
            return back()->withInput()->withErrors('create failed');
        }

        return redirect()->route('user.search')->with('success', ConfigUtil::getMessage('ECL016'));
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
        $loginUser = auth()->user();
        $directorPosition = ValueUtil::constToValue('common.positions.VALID');

        if ($loginUser->position_id !== 0 && strval($loginUser->id) !== $id) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->route('auth.login');
        }

        $user = $this->userRepository->searchById($id);
        $groupNameList = $this->groupRepository->searchGroupName();

        return view('screens.user.addEditDelete', compact('user', 'groupNameList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, string $id) {
        $fields = [
            'name',
            'email',
            'group_id',
            'started_date',
            'position_id',
            'password',
        ];

        $params = $request->only($fields);

        $isExistEmail = $this->userRepository->checkExistsEmail($request->only('email'), $id);

        if ($isExistEmail) {
            return back()->withInput()->withErrors(ConfigUtil::getMessage('EBT019'));
        }

        if (! empty($params['password'])) {
            $params['password'] = EncryptUtil::encryptSha256($params['password']);
        } else {
            unset($params['password']);
        }

        if (! $this->userRepository->update($id, $params)) {
            return back()->withInput()->withErrors('update failed');
        }

        return redirect()->route('user.search')->with('success', ConfigUtil::getMessage('ECL016'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $loginUser = auth()->user();

        $response = [
            'status' => 200,
            'message' => ConfigUtil::getMessage('ECL016'),
        ];

        if ($this->userRepository->deleteById($request->id, $loginUser->id)) {
            return response()->json($response);
        }

        $response['status'] = 400;
        $response['message'] = ConfigUtil::getMessage('EBT086');

        return response()->json($response);
    }
}
