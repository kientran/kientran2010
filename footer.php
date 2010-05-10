<?php
  require 'php/twitterBadge.php';
?>
<footer id="site_footer">
  <div id="footer-container" class="container" >
  <div id="footer-copyright">&copy; 2010 Kien Tran</div>
  <div id="footer-quote"><?php echo twitterBadge('kientran','',1); ?></div>
  </div>
</footer>
<?php $theme->footer(); ?>

<script type="text/javascript">
//<![CDATA[
(function() {
	var links = document.getElementsByTagName('a');
	var query = '?';
	for(var i = 0; i < links.length; i++) {
	if(links[i].href.indexOf('#disqus_thread') >= 0) {
		query += 'url' + i + '=' + encodeURIComponent(links[i].href) + '&';
	}
	}
	document.write('<script charset="utf-8" type="text/javascript" src="http://disqus.com/forums/kientran/get_num_replies.js' + query + '"></' + 'script>');
})();
//]]>
</script>
</body>
</html>
