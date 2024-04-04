<?php

namespace App\Repositories;

use App\Libs\{EncryptUtil, ValueUtil};
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function getModel() {
        return User::class;
    }

    /**
     * Search for users
     * @param mixed $params
     */
    public function search($params) {
        $fields = ['user.id', 'user.name', 'user.email', 'user.started_date', 'user.created_at', 'user.updated_at', 'group.id as group_id', 'group.name as group_name'];

        $query = User::query();

        $query->select($fields);

        $query->selectRaw('
            (CASE
                WHEN user.position_id = 0 THEN "Director"
                WHEN user.position_id = 1 THEN "Group Leader"
                WHEN user.position_id = 2 THEN "Leader"
                WHEN user.position_id = 3 THEN "Member"
                ELSE ""
            END) as position_name
            ');

        $query->leftJoin('group', 'user.group_id', '=', 'group.id');

        if (! empty($params['user_name'])) {
            $query->where('user.name', 'LIKE', '%' . $params['user_name'] . '%');
        }

        if (! empty($params['started_date_from'])) {
            $query->where('started_date', '>=', $params['started_date_from']);
        }

        if (! empty($params['started_date_to'])) {
            $query->where('started_date', '<=', $params['started_date_to']);
        }

        $query->where('user.deleted_at', '=', null)->orderBy('user.name', 'asc')->orderBy('user.started_date', 'asc')->orderBy('user.id', 'asc');

        return $query;
    }

    /**
     * Search by id
     * @param mixed $id
     */
    public function searchById($id) {
        $query = User::query();

        $query->where([['id', $id], ['deleted_at', '=', null]]);

        return $query->first();
    }

    /**
     * Check exist user by email address
     * @param mixed $email
     * @param mixed|null $id
     */
    public function checkExistsEmail($email, $id = null) {
        $query = User::query();

        if (! empty($id)) {
            $query->where('id', '!=', $id);
        }

        $query->where('email', $email);

        return $query->first();
    }
}
