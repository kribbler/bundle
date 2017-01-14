function countDown(dateOfB, dateOfE)
{
	var $ = jQuery;

	var $s = $('.second'),
		$m = $('.minute'),
		$h = $('.hour'),
		$day = $('.day'),
		$sSpan = $s.parent().find('span'),
		$mSpan = $m.parent().find('span'),
		$hSpan = $h.parent().find('span'),
		$daySpan = $day.parent().find('span');

	var initModerniz = function()
	{
		if (Modernizr.canvas){
			$('.knob').knob();
		}
	};

	if (!dateOfE) {
		initModerniz();
		// throw 'Parameter "dateOfE" is empty.'
		return;
	}

	var beforeDate = new Date();
	beforeDate.setDate(beforeDate.getDate() - 2); //x days ago
	
	var dateOfBeginning = dateOfB || beforeDate.toString(),
		maxDate = Date.parse(dateOfE)-Date.parse(dateOfBeginning);

	var curDate = Date.parse(dateOfE) - new Date();
	if (curDate < 0) {
		initModerniz();
		// throw 'Parameter "dateOfE" is a past date.'
		return;
	}

	$day.attr('data-max', Math.floor(maxDate/(1000*60*60*24)))
	initModerniz();

	var clock = function()
	{
		var s = Math.floor((curDate/1000)%60),
			m = Math.floor(curDate/(1000*60)%60),
			h = Math.floor(curDate/(1000*60*60)%24),
			day = Math.floor(curDate/(1000*60*60*24));
		
		if (s < 0) s = 0;
		if (m < 0) m = 0;
		if (h < 0) h = 0;
		if (day < 0) day = 0;

		$s.val(s)
			.trigger('change');
		$m.val(m)
			.trigger('change');
		$h.val(h)
			.trigger('change');
		$day.val(day)
			.trigger('change');

		$sSpan.text(s);
		$mSpan.text(m);
		$hSpan.text(h);
		$daySpan.text(day);

		curDate -= 1000;
		if (curDate > 0) {
			setTimeout(clock, 1000);
		}
	};
	clock();
}
