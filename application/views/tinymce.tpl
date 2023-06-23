<script src="{$url}application/js/tiny_mce/tinymce.min.js"></script>
<script type="text/javascript">
	tinymce.init({
		selector: 'textarea.tinymce',

		height: 400,

		skin: 'oxide-dark',
		content_css: 'dark',

		/* display statusbar */
		statubar: false,

		plugins: 'preview searchreplace autolink autosave directionality visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount code',
		toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | code',
		image_advtab: true
	});
</script>