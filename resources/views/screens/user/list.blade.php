<x-app-layout title="User List" headerTitle="User List">
    <div class="row">
        <div class="col-12">
            <div class="card card-user">
                <form id="searchForm">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <x-forms.text-group id="user_name" label="User Name" name="user_name"
                                    value="{{ request()->input('user_name') }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <x-forms.date-group id="started_date_from" label="Started Date From"
                                    name="started_date_from" value="{{ request()->input('started_date_from') }}" />
                            </div>
                            <div class="col-md-4">
                                <x-forms.date-group id="started_date_to" label="Started Date To" name="started_date_to"
                                    value="{{ request()->input('started_date_to') }}" />
                            </div>
                        </div>
                        <div class="text-right">
                            <x-button.clear label="Clear" />
                            <x-button.base label="Search" type="submit" id="btnSearch"/>
                        </div>
                    </div>

                    <input id="searchParams" type="hidden" value="{{ json_encode($params) }}" />
                </form>
            </div>
            <div id="result" class="card card-user d-none">
                @if (count($users) === 0)
                    <div class="m-3">{{ getMessage('ECL058') }}</div>
                @else
                    <div class="card-footer">
                        {{ $users->links('common.pagination') }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-hover">
                            <table class="table custom-data-table text-nowrap" id="users">
                                <thead>
                                    <tr>
                                        <th width="150px">User Name</th>
                                        <th width="150px">Email</th>
                                        <th width="150px">Group Name</th>
                                        <th width="150px">Started Date</th>
                                        <th width="150px">Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr data-id="{{ $user->id }}">
                                            <td class="user-name">
                                                <x-nav-link to="{{ route('user.edit', $user->id) }}">
                                                    {{ $user->name }}
                                                </x-nav-link>
                                            </td>
                                            @if (auth()->user()->position_id === 0)
                                                <td class="user-email">
                                                    <x-nav-link to="#">
                                                        {{ $user->email }}
                                                    </x-nav-link>
                                                </td>
                                            @else
                                                <td class="user-email">
                                                    {{ $user->email }}
                                                </td>
                                            @endif
                                            <td class="user-group-name">
                                                {{ $user->group_name }}
                                            </td>
                                            <td class="user-started-date">
                                                {{ formatDate('Y-m-d', $user->started_date) }}
                                            </td>
                                            <td class="user-position">
                                                {{ $user->position_name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->position_id === 0)
                    <div class="row">
                        <div class="m-3">
                            <x-button.link to="{{ route('user.create') }}" label="New" />
                            @if (count($users) !== 0)
                                <x-button.base label="Export CSV" id="btnExportCSV" />
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ mix('js/screens/user/list.js') }}"></script>
    @endpush
</x-app-layout>
