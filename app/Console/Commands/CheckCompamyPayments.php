<?php

namespace App\Console\Commands;

use App\Models\CompanyPayments;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckCompamyPayments extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'check:company_payments';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check every day for payment';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 * @throws \Exception
	 */
	public function handle()
	{
		$checkCompaines = CompanyPayments::with(['company', 'company_package.package'])
			->whereHas('company', function ($q) {
				return $q->where('active', true);
			}, '=', 1)
			->whereHas('company_package', function ($q) {
				return $q->whereDate('end_date', '=', Carbon::today());
			}, '=', 1)
			->where('paid', false)
			->get();


		foreach ($checkCompaines as $unpaidcompany) {
			$paid = random_int(1, 1500000000);
			$status = null;
			if ($unpaidcompany->attempt < 3) {
				if (intval(substr(strval($paid), -1)) % 2 == 0) {
					$unpaidcompany->update([
						'paid' => true,
						'paid_date' => Carbon::now(),
						'attempt' => 0
					]);
					if ($unpaidcompany->company_package->package->period == "monthly") {
						$unpaidcompany->company_package->update([
							'start_date' => Carbon::now(),
							'end_date' => Carbon::now()->addMonth()
						]);
					} elseif ($unpaidcompany->company_package->package->period == "yearly") {
						$unpaidcompany->company_package->update([
							'start_date' => Carbon::now(),
							'end_date' => Carbon::now()->addYear()
						]);
					}
					$status = "success";
				} else {
					$unpaidcompany->update([
						'attempt' => $unpaidcompany->attempt + 1
					]);
					$status = "reattempt";
				}
			} else {
				$unpaidcompany->company->update(['active' => false]);
				$status = "error";
			}
			echo $status;
		}
	}
}
