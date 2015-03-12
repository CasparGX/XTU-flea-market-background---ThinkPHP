/**
 *回到顶部js
 * @authors Your Name (you@example.org)
 * @date    2015-02-09 15:31:22
 * @version $Id$
 */
window.onload = function () {
	var obtn = document.getElementById('btn');
	//获取界面可视区域高度
	var cHeight = document.documentElement.clientHeight || document.body.clientHeight;
	var timer = null;
	var isTop = true;
	//滚动条滚动时停止
	window.onscroll = function() {
		var osTop = document.documentElement.scrollTop || document.body.scrollTop;
		if(osTop >= cHeight) {
			obtn.style.display = 'block';
		}else {
			obtn.style.display = 'none';
		}
		if(!isTop) {
			clearInterval(timer);
		}
		isTop = false;
	}
	obtn.onclick = function() {
		//设置定时器
		timer = setInterval(function() {
			//获取滚动条距离顶部高度
			var osTop = document.documentElement.scrollTop || document.body.scrollTop;
			var ispeed = Math.floor(-osTop / 6);
			document.documentElement.scrollTop = document.body.scrollTop = osTop + ispeed;
			isTop = true;
			if (osTop == 0) {
				clearInterval(timer);
			}
		},30)
	}
}