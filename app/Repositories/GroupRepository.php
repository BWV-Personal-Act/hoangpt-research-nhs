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
