<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $fillable = [
		'id','username', 'company_name', 'name', 'password', 'contact_no', 'email', 'website', 'address1', 'address2',
		'city', 'state', 'country', 'zip', 'profile','is_active'
	];

	public function invoices()
	{
		return $this->hasMany(Invoice::class);
	}

	public function projects()
	{
		return $this->hasMany(Project::class);
	}

}
