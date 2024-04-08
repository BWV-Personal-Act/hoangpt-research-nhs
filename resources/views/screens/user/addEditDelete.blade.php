<?php
$position_id = auth()->user()->position_id;
$isDisabled = isset($user) && $position_id !== 0;
?>

<x-app-layout title="{{ isset($user) ? 'Edit User' : 'Add User' }}"
    headerTitle="{{ isset($user) ? 'Edit User' : 'Add User' }}">
    <div class="row">
        <div class="col-12">
            <div class="card card-user">
                <form id="{{ 'addEditForm' }}" method="POST"
                    action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}">
                    @csrf
                    @isset($user)
                        @method('PUT')
                    @endisset

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                @if (isset($user))
                                    <x-forms.text-group id="user_id" label="ID" name="user_id"
                                        value="{{ isset($user) ? $user->id : '' }}" isDisabled />
                                @else
                                    <x-forms.label label="ID" />
                                @endif
                            </div>
                            <div class="col-md-6">
                                <x-forms.text-group id="user_name" label="User Name" name="name"
                                    value="{{ isset($user) ? $user->name : '' }}" :isDisabled="$isDisabled" />
                            </div>
                            <div class="col-md-6">
                                <x-forms.text-group id="email" label="Email" name="email"
                                    value="{{ isset($user) ? $user->email : '' }}" :isDisabled="$isDisabled" />
                            </div>
                            <div class="col-md-6">
                                <x-forms.select-group id="group_id" label="Group" name="group_id" :options="$groupNameList"
                                    value="{{ isset($user) ? $user->group_id : '' }}"
                                    keySelected="{{ isset($user) ? $user->group_id : '' }}" :isDisabled="$isDisabled" />
                            </div>
                            <div class="col-md-6">
                                <x-forms.date-group id="started_date" label="Started Date" name="started_date"
                                    value="{{ isset($user) ? formatDate('Y/m/d', $user->started_date) : '' }}"
                                    :isDisabled="$isDisabled" />
                            </div>
                            <div class="col-md-6">
                                <x-forms.select-group id="position_id" label="Position" name="position_id"
                                    :options="getList('common.positions')" value="{{ isset($user) ? $user->position_id : '' }}"
                                    keySelected="{{ isset($user) ? $user->position_id : '' }}" :isDisabled="$isDisabled" />
                            </div>
                            <div class="col-md-6">
                                <x-forms.text-group id="password" label="Password" type="password" name="password"
                                    value="" />
                            </div>
                            <div class="col-md-6">
                                <x-forms.text-group id="password_confirmation" label="Password Confirmation"
                                    type="password" name="password_confirmation" value="" />
                            </div>
                        </div>
                        <div class="row">
                            <div>
                                @if (!isset($user))
                                    <x-button.base label="Register" />
                                @else
                                    <x-button.base label="Update" />
                                    <x-button.base id="btnDelete" type="button" label="Delete" />
                                @endif
                                    <x-button.link :to="route('user.search')" type="button" label="Cancel" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const DELETE_URL = '{{ route("user.destroy") }}';
            const USER_LIST_URL = '{{ route("user.search") }}';
            const LOGIN_USER_ID = '{{ auth()->user()->id }}';
            const EBT086 = '{{ getMessage("EBT086") }}';
        </script>
        <script src="{{ mix('js/screens/user/addEditDelete.js') }}"></script>
    @endpush
</x-app-layout>
