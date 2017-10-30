<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    const UPDATED_AT = 'update_at';
    const CREATED_AT = 'create_at';

    protected $table = 'user';
    public $timestamps = false;

    protected $fillable = ['rob_point_num_a', 'rob_point_num_b', 'rob_point_num_c'];//开启白名单字段

    public function fromDistribution()
    {
        return $this->hasMany(DistributionRecord2::class,'from_id','id');
    }
    public function toDistribution()
    {
        return $this->hasMany(DistributionRecord2::class,'to_id','id');
    }

    public function downUsers() //获取下级用户
    {
        return $this->hasMany(User::class, 'pid', 'id');
    }

    public function upUser()//获取上级用户
    {
        return $this->belongsTo(User::class,'pid','id');
    }
    /**
     * @return string 根据id获取用户信息
     */
    public function getuserinfo($uid)
    {
        $users = User::where('id', $uid)->first();

        return $users;
    }

    public function investments()
    {
        return $this->hasMany(Investment2::class, 'user_id', 'id');
    }

    public function order2()
    {
        return $this->hasMany(Order2::class, 'user_id', 'id');
    }










//    protected $fillable=['phone','pwd','paypwd'];//设置允许批量赋值的字段

//    protected $guarded=[]; //设置不允许批量赋值的字段可以为空

//    public $timestamps=true;//自动维护时间戳
//
//     protected function getDateFormat()
//     {
//         return time();
//     }
//
//     protected function asDateTime($value)//不格式化时间戳
//     {
//         return $value;
//     }
}
