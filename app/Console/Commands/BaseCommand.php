<?php

namespace App\Console\Commands;

use App\Libs\{
    ConfigUtil,
    DateUtil,
    FileUtil,
    SFtpUtil,
    ValueUtil,
};
use App\Repositories\{BatchStatusRepository, JobManagerRepository};
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\{DB, Log};
use Throwable;

abstract class BaseCommand extends Command
{
    /**
     * The id of batch.
     * Ex: B001
     *
     * @var string
     */
    protected $batchId;

    /**
     * @var
     */
    protected $transaction;

    /**
     * @var
     */
    protected $status = 'success';

    /**
     * @var string
     */
    protected $timestamp = '';

    /**
     * @var string
     */
    protected $e;

    protected $batchStatusRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->batchStatusRepository = app()->make(BatchStatusRepository::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        // log start batch
        $this->batchStart();
        DB::beginTransaction();
        try {
            if ($this->handleBatch()) {
                DB::commit();
            } else {
                DB::rollBack();
            }
        } catch (Exception $e) {
            $this->processError($e);

            return false;
        } catch (Throwable $e) {
            $this->processError($e);

            return false;
        }
        // Log end batch
        $this->batchComplete();

        return true;
    }

    /**
     * Process when exception
     *
     * @param object $e
     */
    public function exception($e) {
        $this->log('error', ConfigUtil::getMessage('batch_system_error') . ' ' . $this->batchId);
        $this->log('error', $e);
        $this->status = 'error';
    }

    /**
     * Handle batch start
     */
    public function batchStart() {
        $this->log('info', "Batch =={$this->batchId}== START");
        $this->log('info', $this->batchId);
        extract(pathinfo(Log::channel('batch')->getHandlers()[0]->getUrl()));
        $this->timestamp = $this->getTimestamp();
        $data = [
            'batch_id' => $this->batchId,
            'status' => ValueUtil::constToValue('batch_status.status.STARTING'),
            'start_time' => Carbon::now(),
            'end_time' => null,
            'log_file_name' => $filename,
        ];
        $collection = $this->batchStatusRepository->create($data);
        $this->transaction = $collection;
    }

    /**
     * Handle batch complete
     * @param mixed|null $e
     */
    public function batchComplete($e = null) {
        if ($this->status == 'success') {
            $data = $this->batchEnd();
        } else {
            $data = $this->batchError();
        }
        $this->batchStatusRepository->update($this->transaction->id, $data, 'id');
        $this->log('info', "Batch =={$this->batchId}== END");
    }

    /**
     * Get data batch end
     */
    public function batchEnd() {
        $data = [
            'status' => ValueUtil::constToValue('batch_status.status.NORMAL_TERMINATION'),
            'end_time' => Carbon::now(),
        ];

        return $data;
    }

    /**
     * Get data batch error
     */
    public function batchError() {
        $data = [
            'status' => ValueUtil::constToValue('batch_status.status.ABNORMAL_TERMINATION'),
            'end_time' => Carbon::now(),
        ];

        return $data;
    }

    /**
     * Handle the main steps of the batch
     *
     * @return bool
     */
    abstract public function handleBatch();

    /**
     * Get timestamp
     *
     * @return string
     */
    public function getTimestamp() {
        return DateUtil::getTimestamp();
    }

    /**
     * Log normal error
     */
    public function logNormalError() {
        $this->log('error', ConfigUtil::getMessage('batch_normal_error') . ' ' . $this->batchId);
        $this->status = 'error';
    }

    /**
     * Log finish success
     */
    public function logFinishSucess() {
        $this->log('info', ConfigUtil::getMessage('batch_finish_success') . ' ' . $this->batchId);
    }

    /**
     * Export csv
     * @param mixed $header
     * @param mixed $lstData
     * @param mixed $fileName
     * @param mixed|null $filePath
     * @param mixed $mode
     * @param mixed $options
     */
    public function exportCsv($header, $lstData, $fileName, $filePath = null, $mode = 'w+', $options = []) {
        return FileUtil::exportCsv($header, $lstData, $fileName, $filePath, $mode, $options);
    }

    /**
     * prinf log batch
     * @param mixed $level
     * @param mixed $message
     */
    public function log($level, $message) {
        Log::channel('batch')->{$level}($message);
    }

    /**
     *  Export csv to s3 and get message from trycatch
     *
     * @param mixed $lstDataCsv
     * @param mixed $headerCsv
     * @param mixed $fileNameCsv
     * @param mixed $filePathCsv
     * @param mixed $mode
     */
    public function exportCsvToS3($lstDataCsv, $headerCsv, $fileNameCsv, $filePathCsv, $mode = 'w+') {
        try {
            return FileUtil::exportCsvToS3($lstDataCsv, $headerCsv, $fileNameCsv, $filePathCsv, $mode);
        } catch (Exception $e) {
            $this->log('error', $e);
            $this->e = $e;

            return false;
        }
    }

    /**
     * Remove file from s3 and get message from trycatch
     *
     * @param object $e
     * @param mixed $fulPaths
     */
    public function removeFileFromS3($fulPaths) {
        try {
            return FileUtil::removeFileFromS3($fulPaths);
        } catch (Exception $e) {
            $this->log('error', $e);
            $this->e = $e;

            return false;
        }
    }

    /**
     * Process error
     *
     * @param object $e
     */
    private function processError($e) {
        DB::rollback();
        $this->exception($e);
        $this->batchComplete($e);
    }
}
