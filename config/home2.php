<?php
return [
    //每天限购次数
    'ROWA_NUM'=>1000,
    'ROWB_NUM'=>1000,
    'ROWC_NUM'=>1000,
    //限制每次只能买几个
    'LIMIT_PAY'=>5,
    //微信支付配置
    'APPID'=>'wxe259aedad693d781',
    'MCH_ID'=>'1352616702',
    'KEY'=>'877e701db74d76616d6cebd5aebc0caf',
    'SECRET'=>'fe296e234d8be43862c6a58a65dc0d9f',
    'NOTIFY_URL'=>'http://test.tjzbdkj.com/callBack/paynotify',//微信回调地址

    //微信App支付配置
    'APP_NOTIFY_URL'=>'http://test.tjzbdkj.com/wxAppPay/notify',

    //微信关注配置
    'GZ_APPID'=>'wx2b2b5d0fb2fe205a',
    'GZ_SECRET'=>'04eff4a84a72660e874b3e8794a16d05',

    //网站域名
    'WEB'=>'http://test.tjzbdkj.com',

    //支付宝支付
    'RETURN_URL'=>'http://test.tjzbdkj.com/home2/aliPay/return_url',//同步回调地址

    //支付宝App支付回调地址
    'ALI_NOTIFY_URL'=>'http://test.tjzbdkj.com/aliAppPay/notify_url',

    //支付宝提现
    'Ali_APPID'=>'2016060101467059',
    'ALIPAYRSAPUBLICKEY'=>'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB',
    'RSAPRIVATEKRY'=>'MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDXf3YFbL7bHrcuVBQtNcRQlo+PGYMQGAVAnd6KH2ngXHsU+wBO5IBTW7tVd5dyVvY8dHnASmikGSZUpMsN2Uk/ftgqQVPQnK6bRCBHW4jb1DmUOXqEbpF52PItR1TeWpTF1ivwP1imh7LgrdreVfz1/0GUhgoXhyA55n3uBw0H4za28gc/iYlU1DE9phAWoeln5FFqFkEjoMUuey7ylVLGKJSJnDfkhK8cHNLoZeKDhMaaly1vidskKjeYdjJQvhjNDlJstOyJp83p8xX3yCTF00odbke044enfJDGhTvtYFydgoVHpIScm+ZN97Pb1HiZijdWuY/JehVFVmZ/zAwFAgMBAAECggEAf4ToVOt1wPpbEWolil8/rSR7DQXevZ5JNWR19KwEHgT7vH2PQCANI8argzbCgqGdEkcmaLhfVYOgYAQoOCi1JIKt7cs8iry8who9M5yhztu1utWMf2NiaIUNQefs+6sEUFGdLIx/rAOuwS9/zYN6riL/LqFmxWdrlXekWz8G4fvnKrS4+uO7VxhZMR++7xeWJPwcsLpNkxCDs3ibx88e4F8XJ4hOsvv3Mk2dz3Tev7APwZb42OPq581ja4maNxrR9GNzjztVR36wuy0r5+bE0pp3fHq8wl93q/ILIaAEz8M5aCW+We+3xOXtGDfrOA+CdbqkOTtWGifdKGVOOnUPnQKBgQDw4CFYAi4TtcQDqR/6Bws59uzEnHNlTMxRpRcdc0tLaWA2TeeT4fu031MLsIkVD8utFLqgYzW+mkQgOYtR/V6jZTC8tcvaZfikH9mvpbq1NYECN54Ga48sObIeN6EaDDqc4yKKjYw5/Tgzuyue2W8QXa5N4lpHqwyxK2ItC8aC7wKBgQDlB2g5G5FZkvjO2aozZ3dwvwYuK4E+W/YyszhwhmEl7C/OEp+dSblsGxqJQlc2muHnu4mVpoAdwVBNeyaKDpGTBhfLVoBEbaF4jjUasL+Yu5jGL2AejpS2L4Ya5ZVUzxfQED+hYCdKkoToeJV3uuF+Frasz3pUw3GPlpMOw9dQSwKBgH5x+a78ffmkyj/tsTaMKg2EnOfdBQqhVQRq+IZiNp1gtLvtC2rrDzn0neCeDGf9AbtbDVkSm2zyCF8uNf+VVO/LN9loSZndO7fUbG6zPh7P9mgWkCLopaDerK0GINDOqJog9cnr4jeywKUPVSevFolt1AlYkHHcze3XS1NAQjYLAoGAZCyWOIxHSe+P5iGsYSl7Q5Q55s3ejOD6UXi0Uftk2Ipy6maY69oIQTGlrK2YqeiasJoFdrBJzznznsAjvjTbFXyPwb+HAOcWvj0tGwx98Rb0npKwLw1cHEezF2adp2ehWb8RpcsBxItLmMbNUX4rDNRweCuTrSmDLTPGBKpCLfsCgYALUyjP6RecOXdxu2ATrk0nOo/JMkEEg6G8wZ5lbPY01VLWDVehktJkcR7IqY6D/n6Dv8kyuWBd+1zz3Y7xtSBdtQlDeN+N5JupMnTNu2uyF2JgyqZiA5YvbEMElokmj6sw3DqKkv5YXE0wWLy7sVLf535LrGmn3fP69WI2qlUVwg==',
];
?>