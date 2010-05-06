
<?php $theme->display('header'); ?>

<div id="content">
<section id="main_content" class="container">

<div id="articles">
<article id="post-<?php echo $post->id; ?>" class="<?php echo $post->statusname; ?>">
  <header id="article_head">
    <div class="article_title">
      <h1><a href="<?php echo $post->permalink; ?>" title="<?php echo $post->title; ?>"><?php echo $post->title_out; ?></a></h1>
    </div>
  </header>

  <section>
    <?php echo $post->content_out; ?>
  </section>

</article>


</div>

</section>
		</div><!-- div#content -->


<?php $theme->display('footer'); ?>

