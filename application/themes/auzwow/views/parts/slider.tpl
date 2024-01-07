{strip}

<!-- Slider/Welcome.Start -->
<div id="slider_welcome" class="slider_welcome" {if !$show_slider}style="display:none"{/if}>
	<div class="aw_container vertical_center">
		<!-- Slider.Start -->
		<div id="slider_container" class="slider_container {if !$theme_configs.config.welcome_box.enabled}wide{/if} border_box anti_blur">
			<div id="slider">
				{foreach from=$slider key=key item=slide}
					{* Default image *}
					{if $slide.image == $image_path}
						{$slide.image = '1.jpg'}
					{/if}

					{* Build caption *}
					{capture assign=caption}
						{if $slide.header || $slide.body || $slide.footer}
							{strip}

							<div class='slider-caption'>
								{if $slide.header}<span class='caption-header'>{$slide.header}</span>{/if}
								{if $slide.body}<span class='caption-body'>{$slide.body}</span>{/if}
								{if $slide.footer}<span class='caption-footer'>{$slide.footer}</span>{/if}
							</div>

							{/strip}
						{/if}
					{/capture}

					<img width="722" height="326" alt="{if $slide.header}{$slide.header} {/if}{if $slide.body}{$slide.body} {/if}{if $slide.footer}{$slide.footer}{/if}" src="{$slide.image}" title="{$caption}" {if key(reset($slider)) != $key}style="display:none"{/if} />
				{/foreach}
			</div>

			<div id="slider_buttons" class="slider_buttons vertical_center"></div>
		</div>
		<!-- Slider.End -->

		{if $theme_configs.config.welcome_box.enabled}{include file="{$theme_path}views/parts/welcome_box.tpl"}{/if}
	</div>
</div>
<!-- Slider/Welcome.End -->

{/strip}