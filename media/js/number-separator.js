$(document).ready(function () {
  // Currency Separator
    var commaCounter = 10;

    function numberSeparator(Number) {
        Number += '';

        for (var i = 0; i < commaCounter; i++) {
            Number = Number.replace(',', '');
        }

        x = Number.split('.');
        y = x[0];
        z = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(y)) {
            y = y.replace(rgx, '$1' + ',' + '$2');
        }
        commaCounter++;
        return y + z;
    }

    // Set Currency Separator to input fields
    $(document).on('keypress , paste', '.number-separator', function (e) {
        if (/^-?\d*[,.]?(\d{0,3},)*(\d{3},)?\d{0,3}$/.test(e.key)) {
            $('.number-separator').on('input', function (e) {
                e.target.value = numberSeparator(e.target.value);
            });
        } else {
            e.preventDefault();
            return false;
        }
    });
  $(document).on('blur', '.number-separator', function (e) {
	  	var text = e.target.value;
		e.target.value = text.replace(/,/g , '');
	});
	
	  $(document).on('keypress , paste', '.disallowminus', function (e){
  if ( event.which == 45 || event.which == 189 ) {
      event.preventDefault();
   }
});
});
