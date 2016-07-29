<?php
/**
 * Functions
 *
 * @package      4runner-child
 * @author       J. Vogelsberg <intrepidjournalist@hotmail.com>
 * @copyright    Copyright (c) 2016, J. Vogelsberg
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */


/* Theme Setup
* This setup function attaches all of the site-wide functions 
* to the correct actions and filters. All the functions themselves
* are defined below this setup function.
*/
add_action('genesis_setup','child_theme_setup', 15);
function child_theme_setup() {

}


/*   Enqueue My Custom Scripts   */
function mytheme_scripts() {

}
add_action( 'wp_enqueue_scripts', 'mytheme_scripts' );






/*
------------------------------------------------------------------------
------------------------------------------------------------------------
------------------------------------------------------------------------
							FROM PERSEVERO
------------------------------------------------------------------------
------------------------------------------------------------------------
------------------------------------------------------------------------
*/

function remove_footer_admin () {
    echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | WordPress Tutorials: <a href="http://www.wpbeginner.com" target="_blank">WPBeginner</a></p>';
} 

add_filter('admin_footer_text', 'remove_footer_admin');

// Create the function to use in the action hook
function remove_dashboard_widgets() {
global $wp_meta_boxes;
// Remove the Other WordPress News
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);	
} 
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
add_action('wp_dashboard_setup', 'wpbeginner_news');

function wpbeginner_news() {
   global $wp_meta_boxes;

   wp_add_dashboard_widget('wpbeginnerdbwidget', 'Latest from WPBeginner', 'db_widget');
}
		function text_limit( $text, $limit, $finish = ' [&hellip;]') {
			if( strlen( $text ) > $limit ) {
		    	$text = substr( $text, 0, $limit );
				$text = substr( $text, 0, - ( strlen( strrchr( $text,' ') ) ) );
				$text .= $finish;
			}
			return $text;
		}

		function db_widget() {
			$options = get_option('wpbeginnerdbwidget');
			$wpbeginnerlogo = get_bloginfo('wpurl') . '/wp-content/themes/persevero/images/wpbeginner.gif';
			$emaillogo = get_bloginfo('wpurl') . '/wp-content/themes/persevero/images/email.gif';
			require_once(ABSPATH.WPINC.'/rss.php');
			if ( $rss = fetch_rss( 'http://wpbeginner.com/feed/' ) ) { ?>
				<div class="rss-widget">
                
				<a href="http://www.wpbeginner.com/" title="Go to WPBeginner.com"><img src="<?php echo $wpbeginnerlogo ?>"  class="alignright" alt="WPBeginner"/></a>			
				<ul>
                <?php 
				$rss->items = array_slice( $rss->items, 0, 5 );
				foreach ( (array) $rss->items as $item ) {
					echo '<li>';
					echo '<a class="rsswidget" href="'.clean_url( $item['link'], $protocolls=null, 'display' ).'">'. ($item['title']) .'</a> ';
					echo '<span class="rss-date">'. date('F j, Y', strtotime($item['pubdate'])) .'</span>';
					
					echo '</li>';
				}
				?> 
				</ul>
				<div style="border-top: 1px solid #ddd; padding-top: 10px; text-align:center;">
				<a href="http://feeds2.feedburner.com/wpbeginner"><img src="<?php get_bloginfo('wpurl') ?>/wp-includes/images/rss.png" alt=""/> Subscribe with RSS</a>
				&nbsp; &nbsp; &nbsp;
				<a href="http://www.wpbeginner.com/wordpress-newsletter/"><img src="<?php echo $emaillogo ?>" alt=""/> Subscribe by email</a>
				</div>
				</div>
			<?php }
		}


?>