<div id="site_sidebar">
  <h3 class="sidebar_top" >Recent Posts</h3>
  <ul class='sidebar_list'>
    <?php
      foreach ($theme->recent_posts as $post) {
        echo '<li><a href="', $post->permalink, '">',
          $post->title, '</a></li>';
      }
    ?>
  </ul>

  <h3>My Other Sites</h3>
  <ul class='sidebar_list'>
    <li><a href='http://blog.kientran.com'>Daily Mind Dump - Random Web Stuff</a></li>
    <li><a href='http://www.seriesregular.com'>Series Regular - TV Show Blog</a></li>
    <li><a href='http://github.com/kientran'>My personal Git Hub</a></li>
  </ul>

<!--
  <h3>Tags</h3>
  <ul class='sidebar_list'>
    <?php if( count($tags) > 0 ) { ?>
      <?php foreach($tags as $tag) { ?>
        <li><a href="<?php Site::out_url( 'habari' );?>/tag/<?php echo $tag->slug; ?>/" rel="tag" title="<?php echo $tag->tag;?>">
          <?php echo $tag->tag; ?>
        </a></li>
      <?php } ?>
    <?php } ?>
  </ul>
-->
</div>

<?php $theme->sidebar(); ?>
