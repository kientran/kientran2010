
<?php $theme->display('header'); ?>

<div id="content">
<section id="main_content" class="container">

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
      Filed under: <?php if ( is_array( $post->tags ) ) { ?><?php echo $post->tags_out; ?><?php } ?><br />
      Version: <?php echo $post->info->version; ?>
    </div>
  </header>

  <section>
    <?php if ( !empty( $post->info->demo_url ) ) { ?>
      <a href='<?php echo $post->info->demo_url; ?>' class='demolink'>Demo</a>
    <?php } ?>
    <?php if ( !empty( $post->info->source_url ) ) { ?>
      <a href='<?php echo $post->info->source_url; ?>' class="sourcelink">Download Source</a>
    <?php } ?>
    <?php echo $post->content_out; ?>
    <?php if ( !empty( $post->info->demo_url ) ) { ?>
      <a href='<?php echo $post->info->demo_url; ?>' class='demolink'>Demo</a>
    <?php } ?>
    <?php if ( !empty( $post->info->source_url ) ) { ?>
      <a href='<?php echo $post->info->source_url; ?>' class="sourcelink">Download Source</a>
    <?php } ?>
    <p>&nbsp;</p>
  </section>

  <footer id="article_footer">
    <?php $theme->comments_link($post); ?>
  </footer>
</article>


</div>

<?php $theme->display('codefolio.sidebar'); ?>


</section>
		</div><!-- div#content -->

<?php $theme->display('footer'); ?>

