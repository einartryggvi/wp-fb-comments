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
	protected $_cache = array();
	protected static $_instance = null;
	protected $_options = null;

	public static function getInstance()
	{
		if (self::$_instance === null) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	protected function __construct()
	{
		$this->_options = json_decode(get_option(get_class($this), '{}'), true);
		$cache = wp_cache_get(get_class($this));
		if ($cache === false) {
			$cache = '{}';
		}
		$this->_cache = json_decode($cache, true);

		if (function_exists('json_decode')) {
			add_filter('get_comments_number', array($this, 'getCommentCount'));
		}
		add_filter('comments_template', array($this, 'commentsTemplate'));
		add_action('wp_head', array($this, 'opgHead'));
		add_action('shutdown', array($this, 'saveOptions'));
		add_action('shutdown', array($this, 'saveCache'));
	}

	public function saveOptions()
	{
		update_option(get_class($this), json_encode($this->_options));	
	}

	public function saveCache()
	{
		wp_cache_set(get_class($this), json_encode($this->_cache), null, 300);
	}

	public function getOption($name)
	{
		return (isset($this->_options[$name])) ? $this->_options[$name] : null;
	}
	
	public function setOption($name, $value)
	{
		$this->_options[$name] = $value;
		return $this;
	}

	public function opgHead()
	{
		$options = $this->_options + array('appID'=>0, 'mods'=>'0');
		echo '<meta property="fb:app_id" content="'.$options['appID'].'"/>';
		echo '<meta property="fb:admins" content="'.$options['mods'].'"/>';
	}

	public function commentsTemplate($args = array(), $postID = 0)
	{
		return dirname(__FILE__) . '/comments.php';
	}

	public function getCommentCount($postID = 0)
	{
		if ($postID === 0) {
			global $post;
			$postID = $post->ID;
		}
		if (!isset($this->_cache[$postID])) {
			$r = wp_remote_get('https://graph.facebook.com/?id='.get_permalink($postID));
			if ($r instanceof WP_Error) {
				$this->_cache[$postID] = 0;
			}
			else {
				$json = json_decode($r['body'], true);	
				$this->_cache[$postID] = (isset($json['comments'])) ? (int)$json['comments'] : 0;
			}
		}
		return $this->_cache[$postID];
	}
}

WP_FB_Comments::getInstance();
