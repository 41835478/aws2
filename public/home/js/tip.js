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
		"font-size": "16px",
		"color": "#333",
		"line-height": "2.6em",
		"border-bottom": "1px solid #e6e6e6"
	});
	title.html("温馨提示");
	//内容
	var show = $("<p></p>");
	show.css({
		"text-align": "justify",
		"padding": "1.2em 0",
		"font-size": "14px",
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
	var btnOk = $("<a id='cancle'></a>");
	btnOk.css({
		"width": "100%",
		"display":"block",
		"height": "2rem",
		"color": "#fff",
		"font-size":"16px",
		"background": "#2194eb",
		"border-radius": "5px",
		"border": "1px solid #2194eb",
		"text-align": "center",
		"line-height": "2rem"
	});
	btnOk.html("确定");
	btnOk.attr("href", url);
	show.html(news);
	btnBox.append(btnOk);
	box.append(title);
	box.append(show);
	box.append(btnBox);
	$($("#out-boxbg")).append(box);
}
