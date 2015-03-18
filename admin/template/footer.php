<!-- End .container -->
<script src="<?="../" . WEBROOT?>/js/bootstarp.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>

	(function($) {
	    $('#copybtn').click(function(e) {
	        e.preventDefault();
	        var $clone = $('#copyinput').clone().attr('id', '').removeClass('hidden');
	        $('#copyinput').before($clone);
	    });
	    $('div.alert-success').delay(2000).fadeIn(2000);
	})(jQuery);

	tinymce.init({
	    selector: 'textarea'
	});

</script>
</body>
</html>
