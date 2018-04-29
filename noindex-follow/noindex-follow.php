<?php
/*
Plugin Name:	Robots "noindex,follow" meta tag
Plugin URI:		
Description:	This plugin is aimed to help your SEO juju by applying the "noindex,follow" robots meta-tag to paginated archives, category, and tag pages with URLs like "www.domain.com/news/page/2" and "www.domain.com/events/page/4" and "www.domain.com/tag/movies/" etc...     
Version:		1.0.0
Author:			Rod Homor
Author URI:		http://www.rodhomor.com/
Text Domain:	noindexfollow
License:		GPL3
 
This plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.
 
This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with This plugin. If not, see https://www.gnu.org/licenses/gpl-3.0.en.html
*/

if ( !class_exists( 'NoIndexFollow' ) ) {
	
    class NoIndexFollow
    {
		// (pattern) regular expressions pattern
		var $noindexfollow_regex_patterns;
		
		// (boolean) if pattern matched, hide content (T/F)
		var $noindexfollow_add_meta_tags;
		
		//  (string) the robots meta tag
		var $noindexfollow_meta_tags;
		
        public function __construct() {
			$this->noindexfollow_regex_patterns = array('/\/tag\/[a-zA-Z0-9\-\_\.]+/', '/\/category\/[a-zA-Z0-9\-\_\.]+/', '/\/page\/[0-9]+/');
            $this->noindexfollow_add_meta_tags = false;
			$this->noindexfollow_meta_tags = '<meta name="robots" content="noindex, follow" />' . "\n";
        }
		
		public function noindexfollow_get_meta_tags() {
			global $template;
			
			if( 'archive' == substr(basename($template), 0, 7) ) {
				$this->noindexfollow_add_meta_tags = true;
			}
			
			else {
				foreach($this->noindexfollow_regex_patterns as $pattern){
					if( preg_match($pattern, $_SERVER['REQUEST_URI']) ){
						$this->noindexfollow_add_meta_tags = true;
						break;
					}
				}
			}
			
			if( $this->noindexfollow_add_meta_tags == true ){
				echo $this->noindexfollow_meta_tags;
			}
		}
    }
 
    $noindexfollow = new NoIndexFollow();
	add_action('wp_head', array($noindexfollow, 'noindexfollow_get_meta_tags'));
	
} // end.

