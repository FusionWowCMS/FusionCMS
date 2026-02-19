<div class="alert alert-info alert-dismissible fade show" role="alert">
	{lang('email_template_notice', 'admin')}
</div>

<form onSubmit="Template.save({$template.id}); return false">
	<div class="card pb-3">
		<div class="card-header">{lang('template', 'admin')}</div>
			<div class="card-body">
				<textarea rows="10" class="form-control" id="code" name="code" data-plugin-codemirror>{$content}</textarea>
			</div>
		</div>
	</div>
<input class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" type="submit" value="{lang('save', 'admin')}">
</form>

<div class="card mt-3">
	<div class="card-header">{lang('preview', 'admin')}</div>
	<div class="card-body">
		<iframe id="preview" style='height: 100%; width: 100%;' frameborder="0" scrolling="auto"></iframe>
	</div>
</div>

<script type="text/javascript">
  var delay;
  var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
    mode           : "htmlmixed",
    theme          : "ayu-mirage",
    tabSize        : 2,
    indentUnit     : 2,
    indentWithTabs : false,
    lineNumbers    : true,
  });
  editor.on("change", function() {
	clearTimeout(delay);
    delay = setTimeout(updatePreview, 300);
  });
  
  function updatePreview() {
    var previewFrame = document.getElementById('preview');
    var preview =  previewFrame.contentDocument ||  previewFrame.contentWindow.document;
    preview.open();
    preview.write(editor.getValue());
    preview.close();
  }
  setTimeout(updatePreview, 300);
</script>

<script>
    // Selecting the iframe element
    var iframe = document.getElementById("preview");
    
    // Adjusting the iframe height onload event
    iframe.onload = function(){
        iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
    }
</script>
