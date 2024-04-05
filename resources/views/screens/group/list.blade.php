<x-app-layout title="Group List" headerTitle="Group List">
    <div class="row">
        <div class="col-12">
            <div id="result" class="card card-user">
                @if (count($groups) === 0)
                    <div class="m-3">{{ getMessage('ECL059') }}</div>
                @else
                    <div class="card-footer">
                        {{ $groups->links('common.pagination') }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-hover">
                            <table class="table custom-data-table text-nowrap" id="users">
                                <thead>
                                    <tr>
                                        <th width="150px">ID</th>
                                        <th width="150px">Group Name</th>
                                        <th width="150px">Group Note</th>
                                        <th width="150px">Group Leader</th>
                                        <th width="150px">Floor Number</th>
                                        <th width="150px">Created Date</th>
                                        <th width="150px">Updated Date</th>
                                        <th width="150px">Deleted Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groups as $group)
                                        <tr data-id="{{ $group->id }}">
                                            <td class="group-id">
                                                {{ $group->id }}
                                            </td>
                                            <td class="group-name">
                                                {{ $group->name }}
                                            </td>
                                            <td class="group-note">
                                                {{ $group->note }}
                                            </td>
                                            <td class="group-leader-name">
                                                {{ $group->leader_name }}
                                            </td>
                                            <td class="group-floor-number">
                                                {{ $group->group_floor_number }}
                                            </td>
                                            <td class="group-created-at">
                                                {{ formatDate('Y-m-d', $group->created_at) }}
                                            </td>
                                            <td class="group-updated-at">
                                                {{ formatDate('Y-m-d', $group->updated_at) }}
                                            </td>
                                            <td class="group-deleted-at">
                                                {{ formatDate('Y-m-d', $group->deleted_at) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="m-3">
                        <form id="importCSVForm" method="POST">
                            <input id="inputFileCSV" name="inputFileCSV" type="file" data-accept-label="CSV" style="visibility: hidden"/>
                        </form>
                        <x-button.base id="btnImportCSV" label="Import CSV" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modal-import">
        <div class="modal-dialog" style="max-width: 720px;">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="importCsvErrorModal"></div>
            <div class="modal-footer">
              <button type="button" class="btn btn-blue-bwv" data-dismiss="modal">
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
    @push('scripts')
        <script>
            const IMPORT_CSV_URL = '{{ route("group.importCSV") }}';
            const ICL097 = '{{ getMessage("ICL097") }}';
        </script>
        <script src="{{ mix('js/screens/group/list.js') }}"></script>
    @endpush
</x-app-layout>
