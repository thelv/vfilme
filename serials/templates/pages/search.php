?parent_template=pages/outer

<script>
	loadPages.init($0url[p]);
</script>

<div id="serials">
	$=blocks[serials]
</div>

<script>
	document.write('<style>#pages{display:none}</style>');
</script>

$=blocks[pages]

<script>
	document.write(loadPages.html);
</script>