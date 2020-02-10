<?php
/*--- REMOVE GENERATOR META TAG ---*/
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'previous_post_rel_link', 10, 0);
remove_action('wp_head', '_ak_framework_meta_tags');
function remove_x_pingback($headers)
{
    unset($headers['X-Pingback']);
    return $headers;
}
add_filter('wp_headers', 'remove_x_pingback');

// register navigations 
register_nav_menus();

// trimming description of categories and tags in the adminbar
// function wph_trim_cats() {
//   add_filter('get_terms', 'wph_truncate_cats_description', 10, 2);
// }
// function wph_truncate_cats_description($terms, $taxonomies) {
//   if('category' != $taxonomies[0] and 'post_tag' != $taxonomies[0])
//       return $terms;
//   foreach($terms as $key=>$term) {
//       $terms[$key]->description = mb_substr($term->description, 0, 80);
//       if($terms[$key]->description != '') {
//           $terms[$key]->description .= '...';
//       }
//   }
//   return $terms;
// }
// add_action('admin_head-edit-tags.php', 'wph_trim_cats');

//added adminbar styles
function admin_style() {
  wp_enqueue_style('admin-styles', get_stylesheet_directory_uri() . '/style.css');
}
add_action('admin_enqueue_scripts', 'admin_style');


// remove css class p1...
function customize_tinymce($in) {
  $in['paste_preprocess'] = "function(pl,o){ o.content = o.content.replace(/p class=\"p[0-9]+\"/g,'p'); o.content = o.content.replace(/span class=\"s[0-9]+\"/g,'span'); }";
  return $in;
}
add_filter('tiny_mce_before_init', 'customize_tinymce');

/**
 * ACF 
 */
// Add Option Page (Home Page)
if (function_exists('acf_add_options_page')) {
  acf_add_options_page(array(
      'page_title' => 'Настройка главной страницы',
      'menu_title' => 'Home Page',
      'menu_slug' => 'acf-options',
      'capability' => 'edit_posts',
      'redirect' => false
  ));
}
// custom admin menu order ACF
function custom_menu_order( $menu_ord ) {  
  if (!$menu_ord) return true;  
  // vars
  $menu = 'acf-options';
  // remove from current menu
  $menu_ord = array_diff($menu_ord, array( $menu ));
  // append after index.php [0]
  array_splice( $menu_ord, 1, 0, array( $menu ) );
  // echo '<pre>';
  // print_r( $menu_ord );
  // echo '</pre>';
  // die;
  // return
  return $menu_ord;
}  
add_filter('custom_menu_order', 'custom_menu_order');
add_filter('menu_order', 'custom_menu_order');
