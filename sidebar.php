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

  <h3>Tags</h3>
  <ul class='sidebar_list'>
    <li><a href="#">Movies</a></li>
    <li><a href="#">Webdev</a></li>
    <li><a href="#">HTML5</a></li>
    <li><a href="#">Movies</a></li>
    <li><a href="#">Webdev</a></li>
  </ul>
</div>

<?php $theme->sidebar(); ?>
