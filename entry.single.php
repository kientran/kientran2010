
<?php $theme->display('header'); ?>

<div id="content">
<section id="main_content" class="container">
<!-- entry.single.php -->
<div id="articles">
<article id="post-<?php echo $post->id; ?>" class="<?php echo $post->statusname; ?>">
  <header id="article_head">
    <div class="article_date">
      <?php echo $post->pubdate->text_format("<span class='day'>{j}</span><span class='month'>{M}</span><span class='year'>{Y}</span>"); ?>
    </div>
    <div class="article_title">
      <h1><a href="<?php echo $post->permalink; ?>" title="<?php echo $post->title; ?>"><?php echo $post->title_out; ?></a></h1>
    </div>
    <div class="article_tags">
      Filed under: <?php if ( is_array( $post->tags ) ) { ?><?php echo $post->tags_out; ?><?php } ?>
    </div>
  </header>

  <section>
    <?php echo $post->content_out; ?>
  </section>

  <footer id="article_footer">
<div id="disqus_thread"></div>
<script type="text/javascript">
  /**
    * var disqus_identifier; [Optional but recommended: Define a unique identifier (e.g. post id or slug) for this thread] 
    */
  (function() {
   var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
   dsq.src = 'http://kientran.disqus.com/embed.js';
   (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
  })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript=kientran">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>

  </footer>
</article>


</div>

<?php $theme->display('sidebar'); ?>


</section>
		</div><!-- div#content -->

<?php $theme->display('footer'); ?>

