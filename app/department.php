<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    use HasFactory;

	protected $fillable = [
		'department_name', 'company_id','department_head','is_active',
	];

	public function company(){
		return $this->hasOne('App\company','id','company_id');
	}

	public function DepartmentHead(){
		return $this->hasOne('App\Employee','id','department_head');
	}


    public function employees(){
		return $this->hasMany(Employee::class,'company_id')->orderBy("id", "ASC");
	}


}
