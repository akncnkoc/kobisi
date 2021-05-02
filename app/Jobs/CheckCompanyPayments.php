<?php

namespace App\Jobs;

use App\Models\Companies;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckCompanyPayments implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


	protected $company;


	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Companies $company)
	{
		$this->company = $company;
		$this->company->load(['company_package', 'company_payments']);
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{

	}
}
