		var personal = document.getElementById('personal');
		var settings = document.getElementById('settings');
		var cartifation = document.getElementById('cartifation');

		var span1 = document.getElementById('span1');
		var span2 = document.getElementById('span2');
		var span3 = document.getElementById('span3');

		function per() {
			personal.style.display = 'block';
			cartifation.style.display = 'none';
			settings.style.display = 'none';

			span1.style.opacity = '1';
			span2.style.opacity = '0.5';
			span3.style.opacity = '0.5';
		}
		function setting() {
			settings.style.display = 'block';
			personal.style.display = 'none';
			cartifation.style.display = 'none';

			span1.style.opacity = '0.5';
			span2.style.opacity = '1';
			span3.style.opacity = '0.5';
		}
		function cart() {
			cartifation.style.display = 'block';
			settings.style.display = 'none';
			personal.style.display = 'none';

			span1.style.opacity = '0.5';
			span2.style.opacity = '0.5';
			span3.style.opacity = '1';
		}