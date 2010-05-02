<?php

/**
* Twitter PHP Badge
*
* This script is an implementation of TwitterCache from Mark Kolich
* of http://mark.kolich.com.  It will take your twitter JSON feed,
* parse it, then scrape it as needed for linkification.  Then it will
* use Gagawa to generate it's HTML code and return that code for page
* insertion.
*
* @author Kien Tran
* @website http://www.kientran.com
* @version 2009.05.21
* @copyright 2009 Kien Tran
* @license http://www.opensource.org/licenses/mit-license.html 
*
* I don't care what you do with this code, but I also take
* NO RESPONSIBILITY for what YOU do with it.
*
* All included modules are copyright of their original
* authors
*/
require_once("JSON.php"); // JSON Parser
require_once("TwitterCacher.php"); // Mark's Cacher
require_once("datehelper.php"); // symfony's date helper

function twitterBadge( $userEmail, $userPassword, $count=1) {

    $json = new Services_JSON();

    // Create the twitter Cacher object to pull feed
    // Password is needed in case feed is protected
    // HTTP Basic Auth hasn't been deprecated...yet...so...lazy wins for now
    $tc = new TwitterCacher($userEmail,$userPassword);
    $tc->setUserAgent("Mozilla/5.0 (compatible; TwitterCacher/1.0; +http://www.kolich.com)");

    //Create a timeline object of the feed (pull from live if old)
    $timeline = $json->decode(
            $tc->getUserTimeline( $count )
            );

    if(!empty ($timeline->error)) {
       return "Authentication Error, please check your username and password"; 
    }

    //create unordered list of tweets (see gagawa module)
    $returnTweet = '';

    foreach( $timeline as $tweet ) {

        $text = $tweet->text;
        //Format date as 5 min ago, 2 hours ago, etc.
        $date = distance_of_time_in_words( strtotime($tweet->created_at) ) . ' ago';

        // Tweet source, i.e. twhril, tweetie, tweetdeck, etc. 
        // $source = $tweet->source;

        // Generate direct link to tweet
        $tweetid = $tweet->id;
        $screenname = $tweet->user->screen_name;
        $tweetlink = 'http://twitter.com/' . $screenname . '/status/' . $tweetid;

        // Turn links into links
        $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1" target="_blank">\\1</a>', $text); 
        // Turn twitter @username into links to the users Twitter page
        $text = preg_replace('/(^|\s)@(\w+)/',
                '\1<a href="http://www.twitter.com/\2">@\2</a>',
                $text);
        // Turn #hashtags into searches
        $text = preg_replace('/(^|\s)#(\w+)/',
                '\1<a href="http://search.twitter.com/search?q=%23\2">#\2</a>',
                $text);

        // Personal Formatting, see Gagawa for documentaiton.
        // <li>Tweet Text <span>(<a href="linktotweet">some time ago</a>)<span></li>

        $returnTweet = $text;
        $tweetDate = '<span id="twitter_date"><a href="' . $tweetlink . '">' . $date . '</a></span>';
        $returnTweet .= $tweetDate;
        
    } //end foreach( $timeline as $tweet )

    return $returnTweet;
    // Returns the stack of li's enclosed by ul
} //end function printTweets

?>
