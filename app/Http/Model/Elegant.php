<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class Elegant extends Model
{
    const UPDATED_AT='update_at';
    const CREATED_AT = 'create_at';

    protected $table='elegant';

    protected $fillable=['name','sex','mobile','ID_code','identity_front','identity_back','identity_hold','agent_name','address',
        'bank_name','account_name','bank_code','bank_img'];//设置允许批量赋值的字段

    protected $guarded=[];//设置不允许批量赋值的字段可以为空

    public $timestamps=true;//自动维护时间戳

    protected function getDateFormat()
    {
        return time();
    }

    protected function asDateTime($value)//不格式化时间戳
    {
        return $value;
    }
}
?>