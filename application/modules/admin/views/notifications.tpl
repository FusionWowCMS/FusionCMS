<div class="p-4" role="none">
{foreach from=$notifications item=notification}
	<div id="headlessui-menu-item-88" role="menuitem" tabindex="-1" data-headlessui-state="">
		<a aria-current="page" href="javascript:void(0)" class="router-link-active router-link-exact-active group flex w-full items-center rounded-md p-2 text-sm transition-colors duration-300 text-muted-500" onClick="Notify.markRead({$notification.id}, this)">
			<div class="ms-2">
				<h6 class="font-heading text-muted-800 text-xs {if !$notification.read}font-semibold{/if} leading-tight dark:text-white"> {$notification.title} </h6>
				<p class="text-muted-400 font-sans text-xs">{date("Y-m-d H:i:s", $notification.time)}</p>
			</div>
		</a>
	</div>
{/foreach}
</div>