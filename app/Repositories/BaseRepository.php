<?php

namespace App\Repositories;

use App\Libs\ValueUtil;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\{DB, Log};

abstract class BaseRepository
{
    protected $model;

    public function __construct() {
        $this->setModel();
    }

    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel() {
        $this->model = app()->make($this->getModel());
    }

    /**
     * Find by id
     *
     * @param string|int $id
     * @param bool $isFindAll
     * @param mixed $ids
     * @return object|bool
     */
    public function findById($ids, $isFindAll = false) {
        try {
            $query = $this->model::query();
            $keys = $this->model->getKeyName();
            if (is_array($keys)) {
                foreach ($keys as $index => $key) {
                    $query->where($key, $ids[$index]);
                }
            } else {
                $query->where($keys, $ids);
            }
            if (! $isFindAll) {
                $query->where('del_flg', ValueUtil::constToValue('common.del_flg.VALID'));
            }

            return $query->first();
        } catch (Exception $e) {
            Log::error($e);

            return false;
        }
    }

    /**
     * Update data
     *
     * @param int $id
     * @param array $params: params need match all fields of model
     * @param bool $isFindAll
     * @return object|mixed|boolean
     */
    public function update($id, $params, $isFindAll = false) {
        try {
            $query = $this->findById($id, $isFindAll);
            $query->fill($params);
            DB::beginTransaction();
            $result = $query->save($params);
            if ($result) {
                DB::commit();
            } else {
                DB::rollBack();
            }

            return $query;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return false;
        }
    }

    /**
     * Create data
     *
     * @param array $params: params need match all fields of model
     * @return object|mixed|boolean
     */
    public function create($params) {
        try {
            DB::beginTransaction();
            $result = $this->model->create($params);
            if ($result) {
                DB::commit();
            } else {
                DB::rollBack();
            }

            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return false;
        }
    }

    /**
     * Delete by id
     *
     * @param string|int $id
     * @return mixed|null
     */
    public function deleteById($id) {
        try {
            if ($query = $this->findById($id)) {
                $query->fill([
                    'del_flg' => ValueUtil::constToValue('common.del_flg.INVALID'),
                ]);

                return $query->save();
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Get del_flg invalid value
     * @param mixed $valid
     */
    public function getDelVal($valid = false) {
        $flg = $valid ? 'VALID' : 'INVALID';

        return ValueUtil::constToValue('common.del_flg.' . $flg);
    }

    /**
     * Check updated_at equal to system date
     *
     * @param bool $isFindAllDisable
     * @param bool $isFindAll
     * @return object|null
     */
    public function checkUpdatedInRecordEqualToSystemDate($isFindAllDisable = false, $isFindAll = false) {
        $query = $this->model->whereDate('updated_at', Carbon::now());
        if (! $isFindAllDisable) {
            $query->where('disable_flg', ValueUtil::constToValue('common.disable_flg.VALID'));
        }
        if (! $isFindAll) {
            $query->where('del_flg', ValueUtil::constToValue('common.del_flg.VALID'));
        }

        return $query->first();
    }

    /**
     * Check updated_at less than system date
     *
     * @param bool $isFindAllDisable
     * @param bool $isFindAll
     * @return object|null
     */
    public function getListHasUpdatedLessThanSystemDate($isFindAllDisable = false, $isFindAll = false) {
        $query = $this->model->whereDate('updated_at', '<', Carbon::now());
        if (! $isFindAllDisable) {
            $query->where('disable_flg', ValueUtil::constToValue('common.disable_flg.VALID'));
        }
        if (! $isFindAll) {
            $query->where('del_flg', ValueUtil::constToValue('common.del_flg.VALID'));
        }

        return $query->get();
    }

    /**
     * Get query string that decrypt Aes256 for the provided statement.
     * The decryption happends on db execution.
     * Usage: search LIKE for a encrypted field
     *
     * @param string $rawStatement raw query (could be table field)
     * @return string the expression to get decrypted data
     */
    public function dbDecryptAes256($rawStatement) {
        $key = ValueUtil::get('common.aes_256_key');
        $iv = ValueUtil::get('common.aes_256_iv');
        DB::statement("SET SESSION block_encryption_mode = 'aes-256-cbc'");

        return "
            CAST(AES_DECRYPT(
                FROM_BASE64({$rawStatement}),
                UNHEX(SHA2('{$key}', 256)),
                FROM_BASE64('{$iv}')) AS CHAR)";
    }
}
