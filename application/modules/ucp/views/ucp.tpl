<div class="container">
	<div class="row">
		{$link_active = "ucp"}
		{include file="../../ucp/views/ucp_navigation.tpl"}
		
		<div class="col-lg-8 py-lg-5 pb-5 pb-lg-0">
			<div class="section-header">{lang("account_overview", "ucp")}</div>
			<div class="section-body">
				<table class="table table-borderless table-responsive user-table">
					<tbody class="text-break">
						<tr>
							<td><div class="user-table-icon"><i class="fas fa-user"></i></div> {lang("nickname", "ucp")}</td>
							<td>{$username}</td>
							<td class="text-end"><a href="{$url}ucp/settings">{lang("edit", "ucp")}</a></td>
						</tr>
						<tr>
							<td><div class="user-table-icon"><i class="fa-solid fa-envelope"></i></div> {lang("email", "ucp")}</td>
							<td>{$email}</td>
							<td class="text-end"><a href="{$url}ucp/settings">{lang("edit", "ucp")}</a></td>
						</tr>
						<tr>
							<td><div class="user-table-icon"><i class="fa-solid fa-key"></i></div> {lang("password", "ucp")}</td>
							<td>********</td>
							<td class="text-end"><a href="{$url}ucp/settings">{lang("edit", "ucp")}</a></td>
						</tr>
						
						<tr><td class="pb-3"></td></tr>
						
						<tr>
							<td><div class="user-table-icon"><i class="fa-solid fa-user-lock"></i></div> {lang("account_status", "ucp")}</td>
							<td colspan="2">{$status}</td>
						</tr>
						<tr>
							<td><div class="user-table-icon"><i class="fa-solid fa-calendar"></i></div> {lang("member_since", "ucp")}</td>
							<td colspan="2">{$register_date}</td>
						</tr>
						<tr>
							<td><div class="user-table-icon"><i class="fa-solid fa-user-shield"></i></div> {lang("account_rank", "ucp")}</td>
							<td colspan="2">{foreach from=$groups item=group} <span {if $group.color}style="color:{$group.color}"{/if}>{$group.name}</span> {/foreach}</td>
						</tr>
						
						<tr><td class="pb-3"></td></tr>
						
						<tr>
							<td><div class="user-table-icon"><i class="fa-solid fa-location-dot"></i></div> {lang("location", "ucp")}</td>
							<td>{$location}</td>
							<td class="text-end"><a href="{$url}ucp/settings">{lang("edit", "ucp")}</a></td>
						</tr>
						
						<tr><td class="pb-3"></td></tr>
						
						<tr class="user-points">
							<td><div class="vote-points user-table-icon"><i class="fa-solid fa-coins"></i></div> {lang("voting_points", "main")}</td>
							<td>{$vp}</td>
							<td class="text-end"><a data-bs-toggle="tooltip" data-bs-placement="top" title="{lang("data_tip_vote", "ucp")}" href="{$url}vote">{lang("vote", "main")}</a></td>
						</tr>
						<tr  class="user-points">
							<td><div class="donation-points user-table-icon"><i class="fa-solid fa-coins"></i></div> {lang("donation_points", "main")}</td>
							<td>{$dp}</td>
							<td class="text-end"><a data-bs-toggle="tooltip" data-bs-placement="top" title="{lang("data_tip_donate", "ucp")}" href="{$url}donate">{lang("donate", "main")}</a></td>
						</tr>
					</tbody>
				</table>
			</div>
			
			{if $characters > 0}
				<div class="section-header">{lang("account_characters", "ucp")}</div>
				<div class="section-body">
					{foreach from=$realms item=realm}
						{if $realm->getCharacterCount() > 0}
                        <div class="table-responsive text-nowrap">
							<table class="nice_table mb-3">
									<thead>
										<tr>
											<th scope="col" colspan="6" class="h4 text-center">{$realm->getName()}</th>
										</tr>
									</thead>
									{foreach from=$realm->getCharacters()->getCharactersByAccount() item=character}
										<tr>
											<td class="col-0">
												<img src="{$url}application/images/stats/{$character.race}-{$character.gender}.gif">
											</td>
											<td class="col-2">
												<img src="{$url}application/images/stats/{$character.class}.gif" width="20px">
											</td>

											{$money = $realmObj->formatMoney($character.money)}
											<td class="col-3">{$character.name}</td>

											<td class="col-4 user-points">
												{if $money}
													<span class="gold-points"><i class="fa-solid fa-coins"></i> {$money["gold"]}</span>
													<span class="silver-points"><i class="fa-solid fa-coins"></i> {$money["silver"]}</span>
													<span class="copper-points"><i class="fa-solid fa-coins"></i> {$money["copper"]}</span>
												{else}
													<span class="copper-points"><i class="fa-solid fa-coins"></i> 0</span>
												{/if}
											</td>

											<td class="col-5">Lv{$character.level}</td>
											<td class="col-6"><a href="{$url}character/{$realm->getId()}/{$character.name}">View</a></td>
										</tr>
									{/foreach}
							</table>
                        </div>
						{/if}
					{/foreach}
				</div>
			{/if}
		</div>
	</div>
</div>