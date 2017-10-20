<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016060101467059",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAm68pMT4VYefydm6zlAYujJ47gsFefN5PTkIEKo0R+JiTU52dimmq8SXXDPtZADiXBp79kxSzfD7A4rsuGUarN5q5seB05hqm7qa3m/rnq4i13sc7T7iQsviOm9slzHvbGNNyM8OJsHfaN0DD8hku1lwXw/TOW76xTBg3plVMX9lBuT/r3dRkzbcLXtU12ksytkJlgMy2bwnD+w8pd88S7eRbZ2rCLuNcCyW/kMqqfdY+7uzCjgr56PyAbp6tJy8VBO9HgyUvXEV+Z1+Oyx66YY8P/VU4T2CcfAsQFU+z5l7M6CH0AqiD0BaiRMAoqBnIljpbOl1rvegD33j4qUY/BQIDAQABAoIBABRn2xBXQNo6Wq9nRyZpwQQxYT98NPRM9zwcrwscvnRFG1pkWFfiDcPZ39wVvc6nnDQD9tymY/gvCX0uZ5ZsitiY8Sn9b5URfTveokZRlrgHDT+MAZwrZtvudFK9YLDysv8IB/n88TkuHG4NkSFUZ601GPBYUAv6bKa6reChYYdWcE2z+94WPQ2SnRPuHU+uYZrZg0LZkLt/8t3A1iD60gbPWC0KBiVNGEMHLSx3THAnTKWAimzt3tSondON2cguPmqMPWVbaMJUfxOerteKw0QuzrbIaArTRYWMuhpIFtzvetkg3bz2Es6dxW+huSdKV+ApWiZwAI6YvB3qhvaX+4ECgYEAysl/q3TfcdnZj8TBb7WShxhQbV0xoUGkzhaxk5yNnBKCjzKYwGK3GxT1ZA0cw2Mwao0WmY7WWVxeXa2sVY7wxFkO47nGtMM7W8T1NjHZusVZXdi7J/GG+vEcAzvmzAmOZpTjQhoU88pEA/09+rAWMZgU5fIMCdeKp8ufWj+Q5FECgYEAxIl2LSfdq1+jtPwH73SKYRM2gsSDMaLp3fCnI/VVhVoPRq53btVvJIbdcSlOJscXLEZDmHj31ojwUMNXJxNxy5x6palHK5IHSr6diEZ9t7MJNFSrQ9PyS/x47M/Oy3XeDjZJKNLyGguljlK9OVKv3uuDYpKzC0bxz/0AoiJ0BnUCgYBWAR2PhzLZI269JdJwYU6y0yIRMAxDewa9jSxlEWmRvtv2hZv5RCSqbLoiY9lGGMRI/GuQVt8b6SvwiR7k7om4jJjfBkR7F64OHrts77mLF/Xt8mR17V61ARtDV91rvcXSReUYfN1UA/3Sv03RC2tuPzTlzUFDz1F0Fs0PxpPZ8QKBgCAsAFRT+k1bUokF2KayBRTu+DVfxboSWQYjpriUKHOz0lxXouVZut/X09f6Uvi2Dm0I83e6FZfgwrX1xAZ5gF88Njd4BlZziQ4LNe5g26N+gzs1wPNRdpBJu+HIAqn7mWXqLP+pyEfLMEaj9KW1i2SKWO+B5B0sd9j8KWZhDW0hAoGBAJxH776Cf1l1fxBum/Mnc8TdLUnzd84WDL/YVAqK/KmlK0bWyRzL8deh5Cc2V6dL7kPA5X3dbTQutKdW1LiQsftC/izf0JbvS9X+LpdeBnYECd0Z+LK7mBW0LGdpQhUzIluXIfIG5JPzv00sHGBe0vFFmlP4BEvkDDv9FBCo8kka",
		
		//异步通知地址
		'notify_url' => "http://www.tjzbdkj.com/alipay/notify_url.php",
		
		//同步跳转
		'return_url' => "http://www.tjzbdkj.com/alipay/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAm68pMT4VYefydm6zlAYujJ47gsFefN5PTkIEKo0R+JiTU52dimmq8SXXDPtZADiXBp79kxSzfD7A4rsuGUarN5q5seB05hqm7qa3m/rnq4i13sc7T7iQsviOm9slzHvbGNNyM8OJsHfaN0DD8hku1lwXw/TOW76xTBg3plVMX9lBuT/r3dRkzbcLXtU12ksytkJlgMy2bwnD+w8pd88S7eRbZ2rCLuNcCyW/kMqqfdY+7uzCjgr56PyAbp6tJy8VBO9HgyUvXEV+Z1+Oyx66YY8P/VU4T2CcfAsQFU+z5l7M6CH0AqiD0BaiRMAoqBnIljpbOl1rvegD33j4qUY/BQIDAQAB",
		
	
);