<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
	use HasFactory;

	protected $fillable = [
		'site_url',
		'name',
		'lastname',
		'companyname',
		'email',
		'password',
		'token',
		'active'
	];

	public function company_package()
	{
		return $this->hasOne(CompanyPackages::class, 'company_id');
	}

	public function company_payments()
	{
		return $this->hasMany(CompanyPayments::class, 'company_id');
	}


	protected $hidden = [
		'token',
		'password',
		'created_at',
		'updated_at'
	];
}
