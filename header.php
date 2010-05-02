<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="generator" content="Habari">
  <title><?php if($request->display_entry && isset($post)) { echo "{$post->title} - "; } ?><?php Options::out( 'title' ) ?></title>

  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

	<!-- define feed information -->
	<link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php $theme->feed_alternate(); ?>">
	<link rel="edit" type="application/atom+xml" title="Atom Publishing Protocol" href="<?php URL::out( 'atompub_servicedocument' ); ?>">
	<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php URL::out( 'rsd' ); ?>">


  <link href="<?php Site::out_url( 'theme' ); ?>/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
  <link href="<?php Site::out_url( 'theme' ); ?>/stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
  <!--[if lt IE 8]>
      <link href="/stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
  <![endif]-->

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

  <script type="text/javascript" src="<?php Site::out_url( 'theme' ); ?>/js/site.js"></script>

  <?php $theme->header(); ?>
</head>

<body class="bp two-col" id="top">


<header id="site_head">
  <div id="head_container">
  <div id="logo_container" class="container">
    <div id="logo">
      <a href="#">
          Kien Tran
      </a>
    </div>
    <div id="actions">
      <a href="#" id="rss">Subscribe</a>  <a href="#" id="twitter">Follow Twitter</a>
    </div>
    <nav>
    <ul>
    <li><a href="#">Resume</a></li>
    <li><a href="#">Codefolio</a></li>
    <li><a href="#">Webfolio</a></li>
    <li><a href="#">Stalk Me</a></li>
    </ul>
    </nav>

  </div>

  <div id="panel">
    <div class="container">

      <div id="about">
        <ul>
          <li>Software Developer</li>
          <li>System Administrator</li>
          <li>Startup Enthusiast</li>
          <li>Web Junkie</li>
          <li>Musican</li>
          <li>Catholic</li>
          <li>Texan</li>
        </ul>
      </div>

      <div id="contact">
        <form class="bp">
          <div id="contact-left">
            <label for="email">Name</label><br />
            <input class="field" type="text" name="name" id="name" value="">

            <label for="email">Email</label><br />
            <input class="field" type="text" name="email" id="email" value="">

            <label for="subject">Subject</label><br />
            <input class="field" type="text" name="subject" id="subject" value="">
          </div>
          <div id="contact-right">
            <label for="comment">Comment</label><br />
            <textarea name="comment" id="comment"></textarea>
          <input type="button" id="comment_submit" value="Say Hello!" />
          <div id="contact_response"></div>
          </div>
        </form>
      </div>

    </div>
  </div>
  </div>

  <div id="tab">
    <div id="tab_container" class="container">
      <div id="pulldown">
        <a href="#" id="open">About Me | Contact</a>
        <a href="#" id="close" >Close Tab</a>
      </div>
    </div>
  </div>
</header>

