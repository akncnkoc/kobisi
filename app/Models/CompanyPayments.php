<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPayments extends Model
{
	use HasFactory;

	protected $fillable = [
		'company_id',
		'company_package_id',
		'paid',
		'attempt',
		'paid_date',
	];

	public function company()
	{
		return $this->belongsTo(Companies::class, 'company_id');
	}



	public function company_package()
	{
		return $this->belongsTo(CompanyPackages::class, 'company_package_id');
	}

}
