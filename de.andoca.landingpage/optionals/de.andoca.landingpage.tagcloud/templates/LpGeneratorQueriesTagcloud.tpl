			{if $LpGeneratorQueries|count}
				<div class="{@$additionalBoxesLpCycle} infoBoxLpGeneratorQueries">
					<div class="containerIcon"><img src="{icon}searchM.png{/icon}" alt="" /></div>
					<div class="containerContent">
						<h3>{lang}de.andoca.landingpage.page.title{/lang}</h3>
						<ul class="tagCloud">
							{foreach from=$LpGeneratorQueries item=$queryString}
								<li><a href="index.php?form=Search&amp;q={@$queryString.string|urlencode}&amp;types[]=post{@SID_ARG_2ND}" title="{$queryString.string}" style="font-size: {@$queryString.size}%;">{$queryString.string|truncate:40}</a></li>
							{/foreach}
						</ul>
					</div>
				</div>
			{/if}