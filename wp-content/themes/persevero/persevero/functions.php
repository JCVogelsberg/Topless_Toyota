<?php 
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