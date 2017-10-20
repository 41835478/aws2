<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>爱无尚-登录页面</title>
    <link href="{{asset('admin/login/css/style.css')}}" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="top">

</div>

<div class="main">
    <div class="denglu">
        <!-- <div class="text" style="font-size:13px;"><strong>重要提示：</strong><br />
          一、考生登录本系统可查看考试结果，还可查看并保存电子合格证书。<br />
          二、国网系统外考生可申请邮寄合格证书，付款一周后在“网银交费”页面可查看邮寄状态及快递单号。<br />
        <font color="red">三、2014年2月24日后不再每日邮寄一次，将改成每两周邮寄一次，整体邮寄工作截止到5月15日。</font></div> -->
        <div class="dlk">
            <form action="{{url('login/login')}}" method="post">
            <table width="292" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="66" colspan="3"></td>
                </tr>
                <tr>
                    <td width="65" style="font-size:14px;"></td>
                    <td width="200" style="font-size:12px;color:red"  colspan="2">
                        @if (Session::has('error'))
                        {{Session::get('error')}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td height="16" colspan="3"></td>
                </tr>
                <tr>
                    <td width="65" style="font-size:14px;">登录账号</td>
                    <td colspan="2"><input name="mobile" type="text" class="dlinput" placeholder="请输入登录账号"/></td>
                </tr>
                <tr>
                    <td width="65" style="font-size:14px;"></td>
                    <td width="200" style="font-size:12px;color:red"  colspan="2">
                        @if(count($errors)>0)
                            @foreach ($errors->get('mobile') as $error)
                                {{ $error }}
                            @endforeach
                        @endif
                    </td>
                </tr>
                <tr>
                    <td height="16" colspan="3"></td>
                </tr>
                <tr>
                    <td>登录密码</td>
                    <td colspan="2"><input name="pwd" type="password" class="dlinput" placeholder="请输入登录密码"/></td>
                </tr>
                <tr>
                    <td width="65" style="font-size:14px;"></td>
                    <td width="200" style="font-size:12px;color:red"  colspan="2">
                        @if(count($errors)>0)
                            {{ $errors->first('pwd') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td height="16" colspan="3"></td>
                </tr>
                <tr>
                    <td>验证码</td>
                    <td width="100"><input name="captcha" type="text" class="dlinput" style="width:90px;" maxlength="4" placeholder="请输入验证码"/></td>
                    <td width="127"><img id="captcha" onclick="javascript:re_captcha();" src="{{url('captcha/1')}}" style="cursor: pointer" width="98" height="35" /></td>
                </tr>
                <tr>
                    <td width="65" style="font-size:14px;"></td>
                    <td width="200" style="font-size:12px;color:red"  colspan="2">
                        @if(count($errors)>0)
                            {{ $errors->first('captcha') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td height="16" colspan="3"></td>
                </tr>
                {{csrf_field()}}
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><input type="submit" value="登 录" class="loginbtn" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><table width="224" border="0" cellspacing="0" cellpadding="0">
                        </table></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>

<div class="footer">Aiwushang &copy; 2017 All Rights Reserved　版权所有 爱无尚网站后台</div>

</body>
</html>
<script>
    function re_captcha(){
        $url="{{url('captcha')}}";
        $url=$url+'/'+Math.random();
        document.getElementById('captcha').src=$url;
    }
</script>
