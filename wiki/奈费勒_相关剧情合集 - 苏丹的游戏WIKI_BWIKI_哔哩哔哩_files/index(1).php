// 来自 https://wiki.biligame.com/seerplan/MediaWiki:Emotion.js
// 源自 赛马娘wiki https://wiki.biligame.com/umamusume
import dataRelease from "./index.php?title=MediaWiki:EmotionData.js&action=raw&ctype=text/javascript&v=0.3";
import dataTest from "./index.php?title=MediaWiki:EmotionDataTest.js&action=raw&ctype=text/javascript&v=0.3";
import emoUI from "./index.php?title=MediaWiki:EmotionUI.js&action=raw&ctype=text/javascript";
import Uma from "./index.php?title=MediaWiki:Uma.js&action=raw&ctype=text/javascript";

const isMobile = Uma.tools.isMobile;

const informTest = `<div style="font-size:12px;margin-left:12px;color:rgb(121,90,54);">\
测试页的表情包功能为开发版本，可以体验最新的功能</div>`;
const informRelease = `<div style="font-size:12px;margin-left:12px;color:rgb(121,90,54);">\
苏丹的游戏主题表情包已上线，欢迎使用~</div>`;

let data = {};
if(mw.config.values.wgPageName === "用户:27684175/表情包测试") {
	data = dataTest;
	//新功能说明
	console.log(isMobile())
	if (isMobile()) {
		$(".title-sub").parent().parent().after(informTest);
	} else {
		$(".comments-title").after(informTest);
	}
} else {
	data = dataRelease;
	//新功能说明
	if (isMobile()) {
		$(".title-sub").parent().parent().after(informRelease);
	} else {
		$(".comments-title").after(informRelease);
	}
}

let [i, j, k, l, m, emoInter, delInter, pageInter, replyInter, notiInter] = [0, 0, 0, 0, 0, null, null, null, null, null];
let [idx, mainInter] = [0, null];


//解析表情
loadCSS();
emoLoadInterval();
mainLoad();
mainLoadInterval();
//载入表情选择ui
emoUI.loadCSS();
emoUI.loadUI(data);


//页面绑定主循环
function mainLoadInterval() {
	idx = 0;
	clearInterval(mainInter);
	mainInter = setInterval(() => {
		mainLoad();
		++idx;
		if (idx > 10) {
			clearInterval(mainInter);
		}
	}, 500);
}


//页面绑定主循环逻辑
function mainLoad() {
	$(".comment-delete").off("click.emo").on("click.emo", () => {
		j = 0;
		clearInterval(delInter);
		delInter = setInterval(() => {
			$("#yes_btn").off("click.emo").on("click.emo", () => {
				emoLoadInterval();
				mainLoadInterval();
			});	
			++j;
			if (j > 10) {
				clearInterval(delInter);
			}
		}, 200);
	});
	$(".comment-submit").off("click.emo").on("click.emo", () => {
		emoLoadInterval();
		mainLoadInterval();
	});
	$(".comment-reply").off("click.emo").on("click.emo", () => {
		l = 0;
		clearInterval(replyInter);
		setTimeout(function() {
			emoUI.loadUI(data);
		}, 300);
		replyInter = setInterval(() => {
			$(".comment-submit").off("click.emo").on("click.emo", () => {
				emoLoadInterval();
				mainLoadInterval();
			});	
			++l;
			if (l > 20) {
				clearInterval(replyInter);
			}
		}, 100);
	});
	
	$(".h5-wiki-comment .bui-reply-send").off("touchstart.emo").on("touchstart.emo", () => {
		emoLoadInterval();
		mainLoadInterval();
	});	
	
	$(".comment-paginator span").off("click.emo1").on("click.emo1", () => {
		k = 0;
		clearInterval(pageInter);
		emoLoadInterval();
		pageInter = setInterval(() => {
			$(".comment-paginator span").off("click.emo2").on("click.emo2", () => {
				emoLoadInterval();
			});	
			++k;
			if (k > 10) {
				clearInterval(pageInter);
			}
		}, 300);
	});
	$("#pt-notifications-alert > a").off("click.emo").on("click.emo", () => {
		m = 0;
		clearInterval(notiInter);
		emoLoadInterval();
		notiInter = setInterval(() => {
			emoLoadInterval();
			$(".oo-ui-buttonElement-button").off("click.emo2").on("click.emo2", () => {
				emoLoadInterval();
			});
			++m;
			if (m > 10) {
				clearInterval(notiInter);
			}
		}, 300);
	});
}


//在页面加载时循环载入
function emoLoadInterval() {
	clearInterval(emoInter);
	i = 0;
    emoInter = setInterval(() => {
		$(".comment-text").each((idx, el) => {
			loadEmo($(el));
		});
		$(".comment-text-mobile").each((idx, el) => {
			loadEmo($(el));
		});
	    $(".reply_content").each((idx, el) => {
			loadEmo($(el));
		});
		++i;
		if (i > 20) {
			clearInterval(emoInter);
			i = 0;
		}
	}, 200);
}

//载入表情
function loadEmo($el) {
	let text = $el.html();
	let emoArr = Array.from(new Set(text.match(/\[&amp;[A-Z][0-9][0-9]\]/g)))
	emoArr = classify(emoArr);
	parseEmo(emoArr, $el);
}

//解析表情代码类属
function classify(arr) {
	let outputArr = [];
	for (let item of arr) {
		outputArr.push(
			{
				"class": item.match(/[A-Z]/g)[0], 
				"id": item.match(/[0-9][0-9]/g)[0],
				"code": item
			}
		);
	}
	return outputArr;
}

//解析并替换评论区表情
function parseEmo(arr, $el) {
	let text = $el.html();
	for (let item of arr) {
		let emo = data[item.class]? data[item.class][item.id]: data.default;
		text = text.replaceAll(item.code, `<img class="emo-img-${item.class}" src="${emo.src}" alt="${emo.name}"></img>`);
	}
	$el.html(text);
}

//载入CSS
function loadCSS() {
	let builder = "";
	for (let key of Object.keys(data)) {
		builder += `.emo-img-${key}{${data[key].css? data[key].css: ""}}`;
	}
	mw.util.addCSS(builder);
}