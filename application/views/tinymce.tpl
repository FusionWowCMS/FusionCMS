<script type="text/javascript">
    require([
		"{$url}application/js/tiny_mce/tinymce.min.js"
	], function () {
			tinymce.init({
				selector: 'textarea.tinymce',

				height: 400,
				
				skin: 'oxide-dark',
				content_css: 'dark',
				
				/* display statusbar */
				statubar: false,
				
				plugins: 'print preview searchreplace autolink autosave directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount textpattern code',
				toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | code',
				image_advtab: true
		});
    });
</script>