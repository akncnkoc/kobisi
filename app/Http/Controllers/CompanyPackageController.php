<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\CompanyPackages;
use App\Models\Packages;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompanyPackageController extends Controller
{

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(Request $request)
	{
		if ($request->isJson()) {
			$validator = \Validator::make($request->all(), [
				'company_id' => 'required|integer',
				'package_id' => 'required|integer',
				'period' => 'in:monthly,yearly'
			], [
				'company_id.required' => "Şirket id'si boş bırakılmamalıdır",
				'package_id.required' => "Paket id'si boş bırakılmamalıdır",
				'company_id.integer' => "Şirket id'si numara olmalıdır",
				'package_id.integer' => "Paket id'si numara olmalıdır",
				'period.in' => 'Paket periyodu uyuşmuyor'
			]);
			if ($validator->fails()) {
				return response()->json(['status' => 'error', 'message' => $validator->errors()]);
			}

			if (!Packages::where('id', $request->get('package_id'))->exists()) {
				return response()->json(['status' => 'error', 'message' => 'Sistemde ' . $request->get('package_id') . " numaralı bir paket bulunamadı"]);
			}

			if (!Companies::where('id', $request->get('company_id'))->exists()) {
				return response()->json(['status' => 'error', 'message' => 'Sistemde ' . $request->get('company_id') . " numaralı bir şirket bulunamadı"]);
			}

			if (CompanyPackages::where('company_id', $request->get('company_id'))->exists()) {
				return response()->json(['status' => 'info', 'message' => 'Sistemde bu şirkete ait paket bulunmaktadır']);
			}

			try {

				$company_package = CompanyPackages::create([
					'package_id' => $request->get('package_id'),
					'company_id' => $request->get('company_id'),
					'start_date' => Carbon::now(),
					'end_date' => $request->get('period') === 'monthly' ? Carbon::now()->addMonth() : Carbon::now()->addYear()
				]);
				return response()->json([
						'status' => 'success',
						'message' => [
							'start_date' => $company_package->start_date,
							'end_date' => $company_package->end_date,
							'package' => Packages::find($request->get('package_id'))
						]
					]
				);
			} catch (\Exception $e) {
				return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
			}
		}
	}

}
