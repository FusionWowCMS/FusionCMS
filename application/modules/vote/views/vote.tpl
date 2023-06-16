<div class="container">
	<div class="row">
		
		{$link_active = "vote"}
		{include file="../../ucp/views/ucp_navigation.tpl"}
		
		<div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
			<div class="section-header">Voting <span>Panel</span></div>
			<div class="section-body">
			<div class="alert alert-info firefox text-center" style="display:none;" role="alert">
			  Please allow pop-up windows from this website to be able to vote.
			</div>
			
				<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
					{if $vote_sites}
						{foreach from=$vote_sites item=vote_site}
							<div class="col mb-3">
								<div class="card h-100 cursor-pointer card-hover {if !$vote_site.canVote}card-disabled{/if}" {if $vote_site.canVote}onClick="Vote.open({$vote_site.id}, {$vote_site.hour_interval});"{/if}>
									<div class="card-header text-center">
										{if $vote_site.vote_image}
											<img src="{$vote_site.vote_image}" alt="{$vote_site.vote_sitename}">
										{else}
											{$vote_site.vote_sitename}
										{/if}
									</div>
									<div class="card-body text-center">
										<div class="card-text h-100 py-3 d-flex justify-content-center align-items-center" id="vote_field_{$vote_site.id}">
											{if $vote_site.canVote}
												{form_open("vote/site/", $formAttributes)}
													<div class="h4">
														{lang('vote_now', 'vote')}
													</div>
													<div class="fst-italic">
													{$vote_site.points_per_vote}
													{if $vote_site.points_per_vote > 1}
														{lang("voting_points", "vote")}
													{else}
														{lang("voting_point", "vote")}
													{/if}
													</div>
													
													<input type="hidden" name="id" value="{$vote_site.id}" />
												</form>
											{else}
												<div class="h4">
													{$vote_site.nextVote} {lang('remaining', 'vote')}
												</div>
											{/if}
										</div>
									</div>
								</div>
							</div>
						{/foreach}
					{/if}
				</div>
			</div>
			
		</div>
	</div>
</div>