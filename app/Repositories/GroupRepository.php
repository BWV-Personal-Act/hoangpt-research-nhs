<?php

namespace App\Repositories;

use App\Libs\{EncryptUtil, ValueUtil};
use App\Models\Group;

class GroupRepository extends BaseRepository
{
    public function getModel() {
        return Group::class;
    }

    /**
     * Search groups
     */
    public function search() {
        $fields = [
            'group.id',
            'group.name',
            'group.note',
            'user.name as leader_name',
            'group.group_floor_number',
            'group.created_at',
            'group.updated_at',
            'group.deleted_at',
        ];

        $query = Group::query();

        $query->select($fields)->leftJoin('user', 'group.group_leader_id', '=', 'user.id')->orderBy('id', 'DESC');

        return $query;
    }

    /**
     * Search names of group
     */
    public function searchGroupName() {
        $query = Group::query();

        $query->select('id', 'name');
        $query->where('deleted_at', '=', null);
        $query->orderBy('name', 'ASC');

        return $query->pluck('name', 'id')->all();
    }
}
