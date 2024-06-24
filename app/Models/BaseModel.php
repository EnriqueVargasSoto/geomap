<?php
/**
 * Created by ExpedioDigital.
 * User: Monica Toribio Rojas
 * Date: 18/03/2018
 * Time: 17:53
 */

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /*
    * Laravel creates a datetime with format of: "Y-m-d H:i:s.u"
    *  SQL Server wants the format of: "Y-d-m H:i:s"
    */
    public function fromDateTime($value)
    {
        return Carbon::parse(parent::fromDateTime($value))->format('Y-d-m H:i:s');
    }
}