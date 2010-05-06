<?php $theme->display('header'); ?>

<div id="content">
<section id="main_content" class="container">

<div id="articles">
<?php foreach ($web_projects as $post ) { ?>
<article id="post-<?php echo $post->id; ?>" class="<?php echo $post->statusname; ?>">
  <header id="article_head">
    <div class="article_date">
      <?php echo $post->pubdate->text_format("<span class='day'>{j}</span><span class='month'>{M}</span><span class='year'>{Y}</span>"); ?>
    </div>
    <div class="article_title">
      <h1><a href="<?php echo $post->permalink; ?>" title="<?php echo $post->title; ?>"><?php echo $post->title_out; ?></a></h1>
    </div>
    <div class="article_tags">
      Tools Used: <?php if ( is_array( $post->tags ) ) { ?><?php echo $post->tags_out; ?><?php } ?>
    </div>
  </header>

  <section>
    <img src='<?php echo $post->info->img_url; ?>' height='120px' width='540px' />
  </section>

</article>

<?php } ?><!-- End post loop -->
    <div class="navigation">
			<div class="alignleft"><?php $theme->prev_page_link(); ?> <?php $theme->page_selector( null, array( 'leftSide' => 2, 'rightSide' => 2 ) ); ?> <?php $theme->next_page_link(); ?></div>
		</div>


</div>

<?php $theme->display('webfolio.sidebar'); ?>


</section>
		</div><!-- div#content -->

<?php $theme->display('footer'); ?>
