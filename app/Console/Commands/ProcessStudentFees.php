<?php

namespace App\Console\Commands;

use App\Services\FeeService;
use Illuminate\Console\Command;

class ProcessStudentFees extends Command
{
    protected $signature = 'fees:process';

    protected $description = 'Process due student fees from wallets';

    public function handle(FeeService $feeService): int
    {
        $this->info('Processing student fees...');

        $processed = $feeService->processDueFees();

        $this->info(
            $processed . ' fee(s) processed successfully.'
        );

        return self::SUCCESS;
    }
}