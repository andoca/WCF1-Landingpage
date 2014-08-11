<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">{foreach from=$links item=$link}
	
	<url>
		<loc>{@PAGE_URL}/index.php?form=Search&amp;q={$link.string|urlencode}&amp;types[]=post</loc>
	</url>{/foreach}

</urlset>