<?php

namespace App\Imports;

use App\Libs\ConfigUtil;
use App\Models\{Group, User};
use App\Rules\{CheckEmailUnique, CheckNumberUnsigned, CheckNumeric, IsDigitsUnsigned, NumberMaxLength};
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{Hash, Session, Validator};
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\{SkipsEmptyRows, ToCollection, WithStartRow};

class GroupImport implements ToCollection, SkipsEmptyRows, WithStartRow
{
    /**
     * @param Collection $rows
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows) {
        $validator = Validator::make($rows->toArray(), [
            '*.0' => ['bail', 'nullable', new CheckNumberUnsigned('ID'), 'max:19'],
            '*.1' => ['bail', 'required', 'max:255'],
            '*.3' => ['bail', 'required', new CheckNumberUnsigned('Group Leader'), 'max:19'],
            '*.4' => ['bail', 'required', new CheckNumberUnsigned('Floor Number'), 'max:9'],
        ]);

        if ($validator->fails()) {
            $errors = [];

            foreach ($validator->failed() as $field => $rules) {
                foreach ($rules as $rule => $params) {
                    [$row, $column] = explode('.', $field);
                    $fieldName = $this->getFieldName($column);
                    $value = $rows[$row][$column];
                    switch ($rule) {
                        case 'App\Rules\CheckNumberUnsigned':
                            $errors[] = $this->errorMessage($row + 1, ConfigUtil::getMessage('EBT010', [$fieldName]));
                            break;
                        case 'Required':
                            $errors[] = $this->errorMessage($row + 1, ConfigUtil::getMessage('ECL001', [$fieldName]));
                            break;
                        case 'App\Rules\NumberMaxLength':
                            $errors[] = $this->errorMessage($row + 1, ConfigUtil::getMessage('ECL002', [$fieldName, 19, strlen($value)]));
                            break;
                    }
                }
            }

            throw new ValidationException($validator, collect($errors));
        } else {
            foreach ($rows as $row) {
                $group = [
                    'name' => $row[1],
                    'note' => $row[2],
                    'group_leader_id' => $row[3],
                    'group_floor_number' => $row[4],
                    'updated_at' => Carbon::now(),
                    'deleted_at' => $row[5] === 'Y' ? Carbon::now() : null,
                ];

                if (! isset($row[0])) {
                    $group['created_at'] = Carbon::now();
                }

                Group::updateOrCreate(
                    ['id' => $row[0]],
                    $group,
                );
            }
        }
    }

    /**
     * @return int
     */
    public function startRow(): int {
        return 2;
    }

    /**
     * @param mixed $row
     * @param mixed $message
     * @return string
     */
    public function errorMessage($row, $message): string {
        return "Row {$row}: {$message}";
    }

    /**
     * @param mixed $column
     * @return string
     */
    public function getFieldName($column): string {
        switch ($column) {
            case '0':
                return 'ID';
            case '1':
                return 'Group Name';
            case '2':
                return 'Group Note';
            case '3':
                return 'Group Leader';
            case '4':
                return 'Floor Number';
            case '5':
                return 'Delete Date';
        }
    }
}
