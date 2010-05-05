<?php

/**
 * This file tells the theme what to do, and is also used to create theme options if desired. See other Habari themes for how this file
 * is used.
 */

/**
 * MyTheme is a custom Theme class for the CleanPress theme.
 *
 * @package Habari
 */

// We must tell Habari to use MyTheme as the custom theme class:
define( 'THEME_CLASS', 'MyTheme' );

/**
 * A custom theme for CleanPress output
 */
class MyTheme extends Theme
{
	/**
	 * Execute on theme init to apply these filters to output
	 */
	public function action_init_theme()
	{
// Apply Format::autop() to post content...
Format::apply( 'autop', 'post_content_out' );
// Apply Format::autop() to comment content...
Format::apply( 'autop', 'comment_content_out' );
// Apply Format::tag_and_list() to post tags...
Format::apply( 'tag_and_list', 'post_tags_out' );

// Remove the comment on the following line to limit post length on the home page to 1 paragraph or 100 characters
//Format::apply_with_hook_params( 'more', 'post_content_out', _t('more'), 100, 1 );
	}

/**
	 * Add additional template variables to the template output.
	 *
	 *  You can assign additional output values in the template here, instead of
	 *  having the PHP execute directly in the template.  The advantage is that
	 *  you would easily be able to switch between template types (RawPHP/Smarty)
	 *  without having to port code from one to the other.
	 *
	 *  You could use this area to provide "recent comments" data to the template,
	 *  for instance.
	 *
	 *  Note that the variables added here should possibly *always* be added,
	 *  especially 'user'.
	 *
	 *  Also, this function gets executed *after* regular data is assigned to the
	 *  template.  So the values here, unless checked, will overwrite any existing
	 *  values.
	 */
	public function add_template_vars()
	{
		//Theme Options
		$this->assign('home_tab','Home'); //Set to whatever you want your first tab text to be.
		$this->assign( 'show_author' , false ); //Display author in posts


		if( !$this->template_engine->assigned( 'pages' ) ) {
			$this->assign('pages', Posts::get( array( 'content_type' => 'page', 'status' => Post::status('published'), 'nolimit' => 1 ) ) );
		}
		if( !$this->template_engine->assigned( 'page' ) ) {
			$page = Controller::get_var( 'page' );
			$this->assign('page', isset( $page ) ? $page : 1 );
		}
		parent::add_template_vars();

		if ( User::identify()->loggedin ) {
			Stack::add( 'template_header_javascript', Site::get_url('scripts') . '/jquery.js', 'jquery' );
		}
    $this->assign('recent_posts',
      Posts::get(array('limit'=>5, 'status'=>'published', 'orderby'=>'pubdate DESC') ) );
    
    if( !$this->template_engine->assigned( 'tags' ) ) {
      $this->assign('tags', Tags::get());
    }

	}

	public function CleanPress_comment_class( $comment, $post )
	{
		$class = 'class="comment';
		if ( $comment->status == Comment::STATUS_UNAPPROVED ) {
			$class.= '-unapproved';
		}
		// check to see if the comment is by a registered user
		if ( $u = User::get( $comment->email ) ) {
			$class.= ' byuser comment-author-' . Utils::slugify( $u->displayname );
		}
		if( $comment->email == $post->author->email ) {
			$class.= ' bypostauthor';
		}

		$class.= '"';
		return $class;
	}

/**
 * If comments are enabled, or there are comments on the post already, output a link to the comments.
 *
 */
	public function comments_link( $post )
	{
		if ( !$post->info->comments_disabled || $post->comments->approved->count > 0 ) {
			$comment_count = $post->comments->approved->count;
			echo "<span class=\"commentslink\"><a href=\"{$post->permalink}#comments\" title=\"" . _t('Comments on this post') . "\">{$comment_count} " . _n( 'Comment', 'Comments', $comment_count ) . "</a></span>";
		}

	}
}

?>

