<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromArray, WithHeadings};

class UserExport implements FromArray, WithHeadings
{
    protected $users;

    public function __construct(array $users) {
        $this->users = $users;
    }

    public function array(): array {
        return $this->users;
    }

    public function headings(): array {
        return [
            'ID',
            'User Name',
            'Email',
            'Group ID',
            'Group Name',
            'Started Date',
            'Position',
            'Created Date',
            'Updated Date',
        ];
    }
}
