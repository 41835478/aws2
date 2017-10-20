<?php
namespace App\Http\Controllers\Admin;

use App\Http\Model\Elegant;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;

class ElegantController extends Controller
{
    protected $elegant;
    public function __construct(Elegant $elegant)
    {
        $this->elegant=$elegant;
    }

    public function index(Request $request)
    {
        $query=$this->elegant->newQuery();
        if($request->has('agent_name'))
            $query->where('agent_name',$request->input('agent_name'));
        if($request->has('mobile'))
            $query->where('mobile',$request->input('mobile'));
        $date=$query->paginate(config('admin.pages'));
        $res=$this->paging($date);
        return view('admin.elegant.index',compact('date','res'));
    }

    public function export()//导出数据
    {
        $data=$this->getElegantData();
        if(count($data)<=0){
            return back()->withErrors('没有可导出的数据');
        }
        $k=0;
        $data1=array();
        foreach($data as $v){
            foreach($v as $val){
                $data1[$k]['id']=$val['id'];
                $data1[$k]['name']=$val['name'];
                $data1[$k]['sex']=$val['sex'];
                $data1[$k]['mobile'] = $val['mobile'];
                $data1[$k]['ID_code'] = $val['ID_code'];
                $data1[$k]['agent_name']=$val['agent_name'];
                $data1[$k]['address']=$val['address'];
                $data1[$k]['bank_name']=$val['bank_name'];
                $data1[$k]['account_name']=$val['account_name'];
                $data1[$k]['bank_code']=$val['bank_code'];
                $data1[$k]['create_at']=$val['create_at'];
                $k++;
            }
        }
        $title=array('编号','用户名','性别','手机号','身份证号','经纪人','用户地址','用户所属银行开户行名称','用户开户行名称','用户银行卡号','注册时间');
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');;
        header('Content-Disposition: attachment;filename='.'贵人币信息表_'.date('Y-m-d',time()).'.xls');//表格文件名
        header('Content-Transfer-Encoding: binary ');
        if (!empty($title)) {
            foreach ($title as $k => $v) {
                $title[$k]=iconv('UTF-8', 'GB2312',$v);//转换编码为utf—8
            }
            $title = implode("\t", $title);//\t空格
            echo $title."\n";//\n为换行//把标题写入表格中
        }
        if (!empty($data)){
            foreach($data1 as $key=>$val){
                foreach ($val as $ck =>$cv) {
                    $data1[$key][$ck]=iconv('UTF-8', 'GB2312', $cv);
                }
                $data1[$key]=implode("\t", $data1[$key]);
            }
            echo implode("\n",$data1);//把数据写入表格中
        }
    }

    public function getElegantData($first = 0, $last = 100, &$date = array(),$j=0)
    {
        $data = Elegant::skip($first)->take($last)->get();
        $data1=array();
        if(count($data) > 0){
            foreach($data as $k=>$v){
                $data1[$k]['id']=$v->id;
                $data1[$k]['name']=$v->name;
                $data1[$k]['sex']=$v->sex;
                $data1[$k]['mobile'] = $v->mobile;
                $data1[$k]['ID_code'] = $v->ID_code;
                $data1[$k]['agent_name']=$v->agent_name;
                $data1[$k]['address']=$v->address;
                $data1[$k]['bank_name']=$v->bank_name;
                $data1[$k]['account_name']=$v->account_name;
                $data1[$k]['bank_code']=$v->bank_code;
                $data1[$k]['create_at']=date('Y-m-d H:i:s',$v->create_at);
            }
            $first = $first + 100;
            $date[$j] = $data1;
            $j++;
            return $this->getElegantData($first, 100, $date,$j);
        }
        return $date;
    }
}
?>