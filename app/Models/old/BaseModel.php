<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
   // Custom constraints here
	function newQuery() {
		$query = parent::newQuery();
		$query->where($this->secondaryKey, '=', $this->type);
		return $query;
	}
}
