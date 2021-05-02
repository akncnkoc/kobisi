<?php

namespace Database\Seeders;

use App\Models\Companies;
use App\Models\CompanyPackages;
use App\Models\CompanyPayments;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class CompaniesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		if (Companies::all()->isEmpty()) {
			$faker = Factory::create('tr_TR');
			for ($i = 0; $i < 1000; $i++) {
				$name = $faker->firstName;
				$lastname = $faker->lastName;
				$uuid = Uuid::uuid4()->toString();
				$token = base64_encode($name . ":" . $lastname) . "-" . $uuid;
				$company = Companies::create([
					'site_url' => $faker->unique()->url,
					'name' => $name,
					'lastname' => $lastname,
					'companyname' => $faker->company,
					'email' => $faker->unique()->email,
					'password' => bcrypt($faker->password(6, 15)),
					'token' => $token,
					'active' => true
				]);
//				$randompackage = $faker->numberBetween(1, 2);
				$randompackage = 1;
				if ($randompackage == 1) {
					$month = $faker->numberBetween(1, 6);
					$day = $faker->numberBetween(1, 29);
					$start_date = Carbon::now()->subMonth($month + 1)->subDay($day);
					$end_date = Carbon::now()->subMonth($month)->subDay($day);
					CompanyPackages::create([
						'package_id' => $faker->numberBetween(1, 2),
						'company_id' => $company->id,
						'start_date' => $start_date,
						'end_date' => $end_date
					]);
				} else {
					$year = $faker->numberBetween(1, 2);
					$month = $faker->numberBetween(1, 12);
					$day = $faker->numberBetween(1, 29);
					$start_date = Carbon::now()->subYear($year + 1)->subMonth($month)->subDay($day);
					$end_date = Carbon::now()->subYear($year)->subMonth($month)->subDay($day);
					CompanyPackages::create([
						'package_id' => $faker->numberBetween(1, 6),
						'company_id' => $company->id,
						'start_date' => $start_date,
						'end_date' => $end_date
					]);
				}
			}
		}
	}
}
