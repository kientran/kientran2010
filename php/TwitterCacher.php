<?php

// Copyright (c) 2009 Mark S. Kolich
// http://mark.kolich.com
//
// July 23, 2009 - Kien Tran
//      Adjusted to allow for blank passwords (unprotected
//          feeds).
//
// May 21, 2009 - Kien Tran - kientran.com
//      Modified getUserTimeline to support discrete
//          number of tweets to pull down
//      Rearranged arguments from loadUserTimeline to put the count
//          argument first
//      Made some other adjustments to allow for discrete num
//          of tweet pulldown
//		Changed name of chachefile to USERNAME.twitter.JSON
//
// Permission is hereby granted, free of charge, to any person
// obtaining a copy of this software and associated documentation
// files (the "Software"), to deal in the Software without
// restriction, including without limitation the rights to use,
// copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the
// Software is furnished to do so, subject to the following
// conditions:
//
// The above copyright notice and this permission notice shall be
// included in all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
// EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
// OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
// NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
// HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
// WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
// FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
// OTHER DEALINGS IN THE SOFTWARE.

// Defines how old the Twitter cache can be in
// seconds before the TwitterCacher calls Twitter
// to refresh itself.  Default is 30 minutes, or 
// 1800 seconds.
define( "REFRESH_INTERVAL", 1800 );

// The default datatype to request from
// the Twitter API.
define( "DEFAULT_DATATYPE", "json" );

class TwitterCacher {

	private $username_;
	private $password_;

	private $response_;
	private $type_;

	private $userAgent_;
	private $headers_ = array( 'Expect:', 'X-Twitter-Client: ',
					'X-Twitter-Client-Version: ',
					'X-Twitter-Client-URL: ' );

	public function __construct ( $username = NULL, $password = NULL,
		$type = DEFAULT_DATATYPE ) {

		if( empty($username)) {
			throw new Exception("Username cannot be empty!");
		}

		$this->username_ = $username;
		$this->password_ = $password;
		
		$this->response_ = array();
		$this->userAgent_ = "";

		$this->type_ = $type;

	}

	public function setUserAgent ( $agent = NULL ) {

		if ( empty($agent) ) {
			throw new Exception("User-Agent cannot be empty!");
		}

		$this->userAgent_ = $agent;

	}

	public function getUserAgent ( ) {
		return $this->userAgent_;
	}

	private function readCache ( ) {

		$cacheFile = $this->username_.".twitter.".$this->type_;
		if(!file_exists($cacheFile)){
			return false;
		}

		$fp = @fopen($cacheFile,"r");
        	$buffer = "";

        	if(!$fp) {
        		return false;
		}
        	else {
                	while(!feof($fp)) {
                        	$buffer .= fgets($fp,4096);
                	}
        	}

        	fclose($fp);
        	return $buffer;

	}

	private function saveCache ( $data ) {

		$cacheFile = $this->username_.".twitter.".$this->type_;
		$fp = @fopen($cacheFile,"w");

		if(!$fp){
			return false;
		}
	
		fwrite($fp,$data);	
	
		fclose($fp);	

	}

	private function getCacheLastModified ( ) {

		$cacheFile = $this->username_.".twitter.".$this->type_;
		return @filemtime($cacheFile);			

	}

	private function loadURL ( $url, $postargs = false, $suppressResponse = false ) {

		$url = ( $suppressResponse ) ? $url . '&suppress_response_code=true' : $url;
		$ch = curl_init($url);

		if ( $postargs !== false ) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postargs);
		}

		if ( $this->username_ !== false &&
			$this->password_ !== false ) {
			curl_setopt($ch, CURLOPT_USERPWD, $this->username_.':'.$this->password_ );	
		}

    	curl_setopt($ch, CURLOPT_VERBOSE, 0);
       	curl_setopt($ch, CURLOPT_NOBODY, 0);
       	curl_setopt($ch, CURLOPT_HEADER, 0);
       	curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent_);
       	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
       	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers_);	
		
		$response = curl_exec($ch);

		$this->response_ = curl_getinfo($ch);
		curl_close( $ch );

		if( intval( $this->response_['http_code'] ) == 200 || intval( $this->response_['http_code'] ) == 401 ) {
			return $response;
		}
		else {
			return false;
		}

	}
	
	private function loadUserTimeline ( $count = 6, $id=false,$since=false,$since_id=false,$page=false ) {
	        
		$qs = array();
        	if( $since !== false ) {
            		$qs[] = 'since='.rawurlencode($since);
		}
		
		if( $since_id ) :
			$since_id = (int) $since_id;
			$qs[] = 'since_id=' . $since_id;
		endif;

		if( $page ) :
			$page = (int) $page;
			$qs[] = 'page=' . $page;
	    	elseif ( $count ) :
	        	$qs[] = 'count=' . (int) $count;
		else :
		    	$qs[] = 'count=20';
		endif;
			
        	$qs = ( count($qs) > 0 ) ? '?' . implode('&', $qs) : '';

            if( empty($this->password_) ) {
                $id = $this->username_;
            }
            
        	if( $id === false ) {
            		$request = 'http://twitter.com/statuses/user_timeline.' . $this->type_ . $qs;
		}
       	 	else {
            		$request = 'http://twitter.com/statuses/user_timeline/' . rawurlencode($id) . '.' . $this->type_ . $qs;
		}
        
		return $this->loadURL($request);
	}

	private function loadAndSave ( $count = 6 ) {

		$data = $this->loadUserTimeline( $count );
		if(!$data){
			throw new Exception("ERROR: Unable to load timeline from Twitter.");
		}
		else {
			$this->saveCache( $data );
			return $data;
		}

	}

	public function getUserTimeline ( $count = 6 ) {

		$last = $this->getCacheLastModified();
		$now = time();	

   		// If the cache file dosen't exist, or if the last time
		// the cache was refreshed was more than REFRESH_INTERVAL
		// seconds ago, then ask Twitter for the latest updates.
		if ( !$last || (( $now - $last ) > REFRESH_INTERVAL) ) {
		// The cache is older than our threshold, so load
			// the latest content from Twitter.
			try { return $this->loadAndSave( $count ); }
			catch ( Exception $e ) { return $e->getMessage(); }
		}
		else {
			// Return what's in the cache file.
			return $this->readCache();
		}

	}
	
}

?>
