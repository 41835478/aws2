<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Wheellist extends Model
{
    const UPDATED_AT='update_at';
    const CREATED_AT = 'create_at';

    protected $table='wheellist';

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
