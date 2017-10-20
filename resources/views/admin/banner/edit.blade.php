<!DOCTYPE html>
<html>

<head>
    @include('admin.layouts.header')
</head>

<body class="gray-bg">
@include('admin.layouts.box')
      <link href="{{asset('admin/css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/footable/footable.core.css')}}" rel="stylesheet">
    <script>
       window.onload = function () { 
          new uploadPreview({ UpBtn: "up_img", DivShow: "imgdiv", ImgShow: "imgShow" });
       }
   </script>
<!-- 
<div style="margin-bottom:10px;border-bottom:1px solid #eee;padding: 0 0 6px;"><a  href="{{url('Banner/index')}}"  >管理轮播图</a><span style="margin-left: 10px;margin-right: 10px;"> </span>  <span style="margin-left: 10px;margin-right: 10px;">
</div> -->

<div class="col-sm-12">
  <div class="tabs-container">
    <ul class="nav nav-tabs">
      <li class="active">
        <a data-toggle="tab" href="#tab-1" aria-expanded="true">修改轮播图</a>
      </li>
    
     </ul>
    <div class="tab-content">
      <div id="tab-1"  class="tab-pane active ">
        <div class="panel-body">
          <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{url('banner/editinfo')}}" enctype="multipart/form-data">
             <div class="form-group">
              <!--   <label class="col-sm-2 control-label">轮播图类别</label>
                <div class="col-sm-5">
                  <select class="form-control" name="type" type="text" id="type" style="padding: 2px 12px;">
                    <option value="0">请选择轮播图类别</option>
                    
                    <option value="2">手机端</option> 
                  </select>
                </div> -->
              </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label">标题</label>
              <div class="col-sm-5">
                  <input class="form-control" name="title" id="title" type="text" value="{{$banner->title}}">
              </div>
             </div> 
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label">URL链接</label>
              <div class="col-sm-5">
                  <input class="form-control" name="url" id="url" type="text" value="{{$banner->url}}">
              </div>
             </div> 
        
            <div class="hr-line-dashed"></div>
            <div class="form-group">
            <label class="col-sm-2 control-label">轮播图</label>
            <div class="col-sm-10" id="imgdiv">
                <input name="pic" type="file" id="up_img" >
                <img  id="imgShow" src="{{$banner->pic}}" style="width:80px;height:80px;margin-bottom:10px;"  >
            </div>
           </div>  
            <input  type="hidden" name="content" value="111" >
     <!--    <div class="hr-line-dashed"></div>
              <div class="form-group">
                   <label class="col-sm-2 control-label">内容</label>
                    <div class="col-sm-10">
                        <textarea  id="content" name="content" style="width:100%;height:300px;"></textarea>
                        
                    </div>
              </div>  -->
           <!--   <div class="hr-line-dashed"></div>
            <div class="form-group">
            <label class="col-sm-2 control-label">内容</label>
            <div class="col-sm-10" id="desc">

            <textarea name="content" style="width:300px;height:100px;margin-bottom:5px;" >
              
            </textarea>
               
            </div> -->
           </div>       
             <div class="hr-line-dashed"></div>
              <div class="form-group">
                <label class="col-sm-2 control-label">启用或禁用</label>
                <div class="col-sm-10">
                  <label class="checkbox-inline">
                    <input value="0" name="status"  type="radio" @if ($banner->status == 0) checked
                                                                  @else
                                                                   
                                                                 @endif >是</label>
                  <label class="checkbox-inline">
                    <input value="1" name="status"  type="radio"  @if ($banner->status == 1) checked
                                                                  @else
                                                                   
                                                                 @endif >否</label></div>
              </div>             
              <div class="hr-line-dashed"></div>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                {{ csrf_field() }}
                   <input type="hidden" name="yin" value="2">
                  <input type="hidden" name='id' value="{{$banner->id}}">
                  <input class="btn btn-primary" type="submit" value="提交" name="dosubmit"><span style="margin-left: 10px;color:red" id="er"></span>
                 </div>
              </div>
            </form>
          </div>
        </div>
      </div>                
    </div>
  </div>
</div>    

   

    <!-- 全局js -->
    <script src="{{asset('admin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}"></script>
    <script src="{{asset('admin/js/plugins/footable/footable.all.min.js')}}"></script>
    <!-- 自定义js -->
      <script src="{{asset('admin/js/content.js?v=1.0.0')}}"></script>
    <script>$(document).ready(function() {
        $('.footable').footable();
        $('.footable2').footable();
      });
        $("tr").mouseenter(function () {
            $(this).css("background","#F0FFF0");
        });
        $("tr").mouseleave(function () {
            $(this).css("background","none");
        })
        function check(){
          var title =  $.trim($("#title").val());
        	var url =  $.trim($("#url").val());
        	if(title == ''){
        		$("#er").html('请输入标题');
        		return false;
        	}else{
        		$("#er").html('');
        	}
          if(url == ''){
            $("#er").html('请输入链接');
            return false;
          }else{
            $("#er").html('');
          }
        	return true;
        }
    </script>
