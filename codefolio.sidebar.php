<div id="site_sidebar">
  <h3 class="sidebar_top" >Code Projects</h3>
  <ul class='sidebar_list'>
    <?php
      foreach ($theme->code_projects as $post) {
        echo '<li><a href="', $post->permalink, '">',
          $post->title, '</a></li>';
      }
    ?>
  </ul>

</div>

<?php $theme->sidebar(); ?>
