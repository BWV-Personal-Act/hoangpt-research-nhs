<x-app-layout title="{{ isset($user) ? 'Edit User' : 'Add User' }}" headerTitle="{{ isset($user) ? 'Edit User' : 'Add User' }}">
    <div class="row">
        <div class="col-12">
            <div class="card card-user">
                <form id="{{ 'addEditForm' }}">
                   <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <x-forms.text-group id="user_id" label="ID" name="user_id" value="{{ isset($user) ? $user->id : '' }}" isDisabled />
                        </div>
                        <div class="col-md-6">
                            <x-forms.text-group id="user_name" label="User Name" name="user_name" value="{{ isset($user) ? $user->name : '' }}"/>
                        </div>
                        <div class="col-md-6">
                            <x-forms.text-group id="email" label="Email" name="email" value="{{ isset($user) ? $user->email : '' }}"/>
                        </div>
                        <div class="col-md-6">
                            <x-forms.select-group id="group" label="Group" name="group" :options="$groupNameList" value="{{ isset($user) ? $user->group_id : '' }}"/>
                        </div>
                        <div class="col-md-6">
                            <x-forms.text-group id="started_date" label="Started Date" name="started_date" value="{{ isset($user) ? $user->started_date : '' }}"/>
                        </div>
                        <div class="col-md-6">
                            <x-forms.select-group id="position" label="Position" name="position" :options="getList('common.positions')" value="{{ isset($user) ? $user->position_id : '' }}"/>
                        </div>
                        <div class="col-md-6">
                            <x-forms.text-group id="password" label="Password" name="password" value=""/>
                        </div>
                        <div class="col-md-6">
                            <x-forms.text-group id="password_confirmation" label="Password Confirmation" name="password_confirmation" value=""/>
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            @if (!isset($user))
                            <x-button.base label="Register" />
                            @else
                                <x-button.base label="Update" />
                                <x-button.base type="button" label="Delete" />
                            @endif
                            <x-button.base type="button" label="Cancel" />
                        </div>
                    </div>
                   </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ mix('js/screens/user/addEditDelete.js') }}"></script>
    @endpush
</x-app-layout>
