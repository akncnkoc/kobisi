<?php

namespace Database\Seeders;

use App\Models\Packages;
use Illuminate\Database\Seeder;

class PackagesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return string
	 */
	public function run()
	{
		if (Packages::all()->isEmpty()) {
			$packages = [
				['name' => 'NoFee', 'price' => 0, 'period' => 'monthly'],
				['name' => 'Personal', 'price' => 99, 'period' => 'monthly'],
				['name' => 'Plus', 'price' => 149, 'period' => 'monthly'],
				['name' => 'Professional', 'price' => 249, 'period' => 'monthly'],
				['name' => 'NoFee', 'price' => 0, 'period' => 'yearly'],
				['name' => 'Personal', 'price' => 212, 'period' => 'yearly'],
				['name' => 'Plus', 'price' => 127, 'period' => 'yearly'],
				['name' => 'Professional', 'price' => 212, 'period' => 'yearly'],
			];
			foreach ($packages as $package) {
				try {
					Packages::create($package);
				} catch (\Exception $e) {
					return $e->getMessage();
				}
			}
		}
	}
}
