<?php
/**
 * Plugin Name: Easy Facebook Comments
 * Plugin URI: http://github.com/einartryggvi/wp-fb-comments
 * Description: Wordpress Plugin for seamless Facebook comments intergration, including comment count etc.
 * Version: 0.1
 * Author: Einar Tryggvi Leifsson
 * Author URI: http://www.einar.me
 * License: Apache v2
 */

class WP_FB_Comments
{
	protected static $_cache = array();

	public static function opg_head()
	{
		##$options = get_option('WP_FB_Comments');
		$options = array('appID'=>0, 'mods'=>'0');
		echo '<meta property="fb:app_id" content="'.$options['appID'].'"/>';
		echo '<meta property="fb:admins" content="'.$options['mods'].'"/>';
	}

	public static function comments_template($args = array(), $postID = 0)
	{
		return dirname(__FILE__) . '/comments.php';
	}

	public static function get_comment_number($postID = 0)
	{
		if ($postID === 0) {
			global $post;
			$postID = $post->ID;
		}
		if (!isset(self::$_cache[$postID])) {
			$r = wp_remote_get('https://graph.facebook.com/?id='.get_permalink($postID));
			if ($r instanceof WP_Error) {
				self::$_cache[$postID] = 0;
			}
			else {
				$json = json_decode($r['body'], true);	
				self::$_cache[$postID] = (isset($r['comments'])) ? (int)$r['comments'] : 0;
			}
		}
		return self::$_cache[$postID];
	}
}

if (function_exists('json_decode')) {
	add_filter('get_comments_number', 'WP_FB_Comments::get_comment_number');
}
add_filter('comments_template', 'WP_FB_Comments::comments_template');
add_action('wp_head', 'WP_FB_Comments::opg_head');
