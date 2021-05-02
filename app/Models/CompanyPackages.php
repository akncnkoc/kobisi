<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPackages extends Model
{
	use HasFactory;
	protected $fillable = [
		'company_id',
		'package_id',
		'start_date',
		'end_date'
	];

	public function package(){
		return $this->belongsTo(Packages::class, 'package_id');
	}

	protected $hidden = [
		'created_at',
		'updated_at',
		'company_id',
		'package_id'
	];

}
