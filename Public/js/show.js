/**
 *内容页js，图片显示
 * @authors Your Name (you@example.org)
 * @date    2015-02-14 16:49:42
 * @version $Id$
 */
	var pic_1 = document.getElementById('pic-1');
	var pic_2 = document.getElementById('pic-2');
	var pic_3 = document.getElementById('pic-3');
	var sm1 = document.getElementById('sm1');
	var sm2 = document.getElementById('sm2');
	var sm3 = document.getElementById('sm3');

	pic_1.style.display = 'block';
	pic_2.style.display = 'none';
	pic_3.style.display = 'none';

	function pic1() {
		pic_1.style.display = 'block';
		pic_2.style.display = 'none';
		pic_3.style.display = 'none';
		sm1.style.border = "3px solid #f88f55";
		sm2.style.border = "1px solid #fcfcfc";
		sm3.style.border = "1px solid #fcfcfc";
	}
	function pic2() {
		pic_1.style.display = 'none';
		pic_2.style.display = 'block';
		pic_3.style.display = 'none';
		sm2.style.border = "3px solid #f88f55";
		sm1.style.border = "1px solid #fcfcfc";
		sm3.style.border = "1px solid #fcfcfc";
	}
	function pic3() {
		pic_1.style.display = 'none';
		pic_2.style.display = 'none';
		pic_3.style.display = 'block';
		sm3.style.border = "3px solid #f88f55";
		sm1.style.border = "1px solid #fcfcfc";
		sm2.style.border = "1px solid #fcfcfc";
	}