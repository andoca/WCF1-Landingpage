{include file="documentHeader"}
<head>
	<title>{lang}de.andoca.landingpage.page.title{/lang} - {PAGE_TITLE}</title>
	{capture append=specialStyles}
		<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_WCF_DIR}style/extra/rules{if PAGE_DIRECTION == 'rtl'}-rtl{/if}.css" />
	{/capture}
	{include file='headInclude' sandbox=false}
	<meta name="robots" content="noindex,follow" />
</head>
<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>
{include file='header' sandbox=false}

<div id="main" class="rules">
	
	<ul class="breadCrumbs">
		<li><a href="index.php?page=Index{@SID_ARG_2ND}"><img src="{icon}indexS.png{/icon}" alt="" /> <span>{PAGE_TITLE}</span></a> &raquo;</li>
	</ul>
	
	<div class="mainHeadline">
		<img src="{icon}searchL.png{/icon}" alt="" />
		<div class="headlineContainer">
			<h2>{lang}de.andoca.landingpage.page.title{/lang}</h2>
		</div>
	</div>
	
	{*if $userMessages|isset}{@$userMessages}{/if*}
	<div class="border content">
		<div class="container-1">
			<p>{lang}de.andoca.landingpage.page.desc{/lang}</p>
			{if $links|count}
				<ul class="tagCloud">
					{foreach from=$links item=$queryString}
						<li><a href="index.php?form=Search&amp;q={@$queryString.string|urlencode}&amp;types[]=post{@SID_ARG_2ND}" title="{$queryString.string}" style="font-size: {@$queryString.size}%;vertical-align: middle">{$queryString.string|truncate:40}</a></li>
					{/foreach}
				</ul>
			{/if}
		</div>
	</div>
</div>

{include file='footer' sandbox=false}

</body>
</html>