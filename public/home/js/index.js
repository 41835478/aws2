/*
* @Author: Administrator
* @Date:   2017-08-14 10:03:38
* @Last Modified by:   Administrator
* @Last Modified time: 2017-08-19 16:05:57
*/

'use strict';
/*Shuffling figure*/
$(function () {
    var mySwiper = new Swiper ('.index-banner',{
        direction: 'horizontal',
        loop: true,
        autoplay : 3000,
        pagination: '.swiper-pagination',
        autoplayDisableOnInteraction : false,
        observer:true,
        observerParents:true
     }); 
});
//生成半透明遮罩
function addBox(out,zi) {
    if (!zi) {
        zi = 10;
    }
    var box = $("<div></div>");
    box.css({
        "width": "100%",
        "min-height": "100vh",
        "position": "fixed",
        "top": "0",
        "left": "0",
        "background": "rgba(0,0,0,0.4)",
        "zIndex": zi
    });
    box.attr("id", "out-boxbg");
    if ($(out).css("position") === "static") {
        $(out).css("position", "relative");
    }
    box.on("touchstart", function (e) {
        if (e.target === box[0]) {
            e.preventDefault();
        }
    });
    $(out).append(box);
    return "out-boxbg";
}

//生成弹出框
function outBox(news, url) {
    if (!news) {
        news = "";
    }
    if (!url) {
        url = " ";
    }
    //盒子
    var box = $("<div></div>");
    box.css({
        "position": "absolute",
        "top": "24vh",
        "left": "7%",
        "width": "86%",
        "background": "#fff",
        "border-radius": "10px",
        "box-sizing": "border-box",
        "padding": "10px 20px"
    });
    //标题
    var title = $("<h4></h4>");
    title.css({
        "text-align": "center",
        "font-size": "18px",
        "color": "#333",
        "line-height": "2.6em",
        "border-bottom": "1px solid #e6e6e6"
    });
    title.html("确定使用5900消费积分兑换商品？");
    //内容
    var show = $("<p></p>");
    show.css({
        "text-align": "justify",
        "padding": "1.2em 0 1rem 0",
        "font-size": "15px",
        "line-height": "2em",
        "color": "#333"
    });
    //确认取消
    var btnBox = $("<div></div>");
    btnBox.css({
        "width": "100%",
        "overflow": "hidden",
        "padding-bottom": "10px"
    });
    var btnNo = $("<a></a>");
    btnNo.css({
        "float": "left",
        "width": "45%",
        "height": "2rem",
        "color": "#333",
        "background": "#ebebeb",
        "border-radius": "3px",
        "border": "1px solid #999",
        "text-align": "center",
        "font-size":"16px",
        "line-height": "2rem"
    });
    var btnOk = $("<a class='makeSure'></a>");
    btnOk.css({
        "float": "right",
        "width": "45%",
        "height": "2rem",
        "color": "#fff",
        "background": "#2194eb",
        "border-radius": "3px",
        "border": "1px solid #2194eb",
        "text-align": "center",
        "font-size":"16px",
        "line-height": "2rem"
    });
    btnNo.html("取消");
    btnOk.html("兑换");
    btnOk.attr("href", url);
    btnNo.on("touchend", function () {
        setTimeout(function () {
            $($("#out-boxbg")).remove();
        }, 50);
    });
    show.html(news);
    btnBox.append(btnNo);
    btnBox.append(btnOk);
    box.append(title);
    box.append(show);
    box.append(btnBox);
    $($("#out-boxbg")).append(box);
};
//生成弹出框
function outBoxx(news, url) {
    if (!news) {
        news = "";
    }
    if (!url) {
        url = " ";
    }
    //盒子
    var box = $("<div></div>");
    box.css({
        "position": "absolute",
        "top": "24vh",
        "left": "7%",
        "width": "86%",
        "background": "#fff",
        "border-radius": "10px",
        "box-sizing": "border-box",
        "padding": "10px 20px"
    });
    //标题
    var title = $("<h4></h4>");
    title.css({
        "text-align": "center",
        "font-size": "18px",
        "color": "#333",
        "line-height": "2.6em",
        "border-bottom": "1px solid #e6e6e6"
    });
    title.html("提示");
    //内容
    var show = $("<p></p>");
    show.css({
        "text-align": "justify",
        "padding": "1.2em 0",
        "font-size": "16px",
        "line-height": "2em",
        "color": "#333"
    });
    //确认取消
    var btnBox = $("<div></div>");
    btnBox.css({
        "width": "100%",
        "overflow": "hidden",
        "padding-bottom": "10px"
    });
    var btnNo = $("<a></a>");
    btnNo.css({
        "float": "left",
        "width": "45%",
        "height": "2rem",
        "color": "#333",
        "background": "#ebebeb",
        "border-radius": "5px",
        "border": "1px solid #999",
        "text-align": "center",
        "font-size":"16px",
        "line-height": "2rem"
    });
    var btnOk = $("<a class='makeSure'></a>");
    btnOk.css({
        "float": "right",
        "width": "45%",
        "height": "2rem",
        "color": "#fff",
        "background": "#2194eb",
        "border-radius": "5px",
        "border": "1px solid #2194eb",
        "text-align": "center",
        "font-size":"16px",
        "line-height": "2rem"
    });
    btnNo.html("取消");
    btnOk.html("下载APP");
    btnOk.attr("href", url);
    btnNo.on("touchend", function () {
        setTimeout(function () {
            $($("#out-boxbg")).remove();
        }, 50);
    });
    show.html(news);
    btnBox.append(btnNo);
    btnBox.append(btnOk);
    box.append(title);
    box.append(show);
    box.append(btnBox);
    $($("#out-boxbg")).append(box);
};
//生成弹出框
function outBoxc(news, url) {
    if (!news) {
        news = "";
    }
    if (!url) {
        url = " ";
    }
    //盒子
    var box = $("<div></div>");
    box.css({
        "position": "absolute",
        "top": "24vh",
        "left": "7%",
        "width": "86%",
        "background": "#fff",
        "border-radius": "10px",
        "box-sizing": "border-box",
        "padding": "10px 20px"
    });
    //标题
    var title = $("<h4></h4>");
    title.css({
        "text-align": "center",
        "font-size": "18px",
        "color": "#333",
        "line-height": "2.6em",
        "border-bottom": "1px solid #e6e6e6"
    });
    title.html("提示");
    //内容
    var show = $("<p></p>");
    show.css({
        "text-align": "justify",
        "padding": "1.2em 0",
        "font-size": "16px",
        "line-height": "2em",
        "margin-bottom":"1rem",
        "color": "#333"
    });
    //确认取消
    var btnBox = $("<div></div>");
    btnBox.css({
        "width": "100%",
        "overflow": "hidden",
        "padding-bottom": "10px"
    });
    var btnNo = $("<a></a>");
    btnNo.css({
        "float": "left",
        "width": "45%",
        "height": "2rem",
        "color": "#333",
        "background": "#ebebeb",
        "border-radius": "5px",
        "border": "1px solid #999",
        "text-align": "center",
        "font-size":"16px",
        "line-height": "2rem"
    });
    var btnOk = $("<a class='makeSure'></a>");
    btnOk.css({
        "float": "right",
        "width": "45%",
        "height": "2rem",
        "color": "#fff",
        "background": "#2194eb",
        "border-radius": "5px",
        "border": "1px solid #2194eb",
        "text-align": "center",
        "font-size":"16px",
        "line-height": "2rem"
    });
    btnNo.html("取消");
    btnOk.html("确定");
    btnOk.attr("href", url);
    btnNo.on("touchend", function () {
        setTimeout(function () {
            $($("#out-boxbg")).remove();
        }, 50);
    });
    show.html(news);
    btnBox.append(btnNo);
    btnBox.append(btnOk);
    box.append(title);
    box.append(show);
    box.append(btnBox);
    $($("#out-boxbg")).append(box);
};
/*set img height*/
window.onload = function(){
    var _h = $('.indexGoodsimg').width();
    $('.indexGoodsimg').css('height',_h);
};