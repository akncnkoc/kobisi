<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Validator;

class CompainesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		return response()->json(Companies::all());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(Request $request)
	{
		if ($request->isJson()) {

			$validator = Validator::make($request->all(), [
				'site_url' => 'required|max:150',
				'name' => 'required',
				'lastname' => 'required',
				'companyname' => 'required',
				'email' => 'required|email',
				'password' => 'required'
			], [
				'site_url.required' => 'Site linki gönderilmesi zorunludur',
				'name.required' => 'Ad boş bırakılamaz',
				'lastname.required' => 'Soyad boş bırakılamaz',
				'companyname.required' => 'Şirket adı boş bırakılamaz',
				'email.required' => 'Email boş bırakılmamalıdır',
				'email.email' => 'Email adresini düzgün bir formatta girin',
				'password' => 'Şifre boş bırakılmamalıdır'
			]);
			if ($validator->fails()) {
				return response()->json(['status' => 'info', 'message' => $validator->errors()]);
			}
			if (Companies::where('email', $request->get('email'))->exists()) {
				return response()->json(['status' => 'error', 'message' => $request->get('email') . ' bu mail daha önceden kayıt edilmiş'], 500);
			}

			try {
				$company = Companies::create([
					'site_url' => $request->get('site_url'),
					'name' => $request->get('name'),
					'lastname' => $request->get('lastname'),
					'companyname' => $request->get('companyname'),
					'email' => $request->get('email'),
					'password' => bcrypt($request->get('password')), // bcrypt for storing,
					'token' => base64_encode($request->get('name') . ":" . $request->get('lastname')) . "-" . Uuid::uuid4()->toString()
				]);
				return response()->json(['status' => 'success', 'message' => ['token' => $company->token, 'company_id' => $company->id]]);
			} catch (\Exception $e) {
				return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
			}
		} else {
			return response()->json(['status' => 'info', 'message' => 'Gönderilen verilerin application/json formatında olaması gereklidir']);
		}
	}

	public function check_company_package(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'token' => 'required'
		], [
			'token.required' => 'Token bilgisi bulunamadı'
		]);

		if ($validator->fails()) {
			return response()->json(['status' => 'error', 'message' => $validator->errors()], 500);
		}

		if (!Companies::where('token', $request->get('token'))->exists()) {
			return response()->json(['status' => 'info', 'message' => 'Bu ' . $request->get('token ') . " tokene ait bir şirket bulunamadı"]);
		}

		return response()->json(['status' => 'success', 'message' => Companies::with(['company_package.package'])->get()]);

	}
}
