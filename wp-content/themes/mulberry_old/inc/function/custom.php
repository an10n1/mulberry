<?php 

function unar_get_tag_id_by_name($tag_name) 
{
    global $wpdb;
    $tag_ID = $wpdb->get_var("SELECT * FROM ".$wpdb->terms." WHERE  `name` =  '".$tag_name."'");

    return $tag_ID;
}



//EXCERPT

function unar_excerpt($limit) 
{
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt).'&hellip';
    } else {
        $excerpt = implode(" ", $excerpt);
    } 
    $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
    return $excerpt;
}
 
function unar_content($limit) 
{
    $content = explode(' ', get_the_content(), $limit);
    if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ", $content).'&hellip';
    } else {
        $content = implode(" ", $content);
    } 
    $content = preg_replace('/\[.+\]/', '', $content);
    $content = apply_filters('the_content', $content); 
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}


function unar_custom_excerpt_length( $length ) 
{
    return 40;
}
add_filter('excerpt_length', 'unar_custom_excerpt_length', 999);

function unar_new_excerpt_more( $more ) 
{
    return '...';
}
add_filter('excerpt_more', 'unar_new_excerpt_more');

// portfolio category
function unar_portfolio_category() {

global $post;

$terms = get_the_terms( $post->ID, 'portfolio-category' );
                    
        if ( $terms && ! is_wp_error( $terms ) ) : 

          $portfolio_skill = array();

          foreach ( $terms as $term ) {
            $portfolio_skill[] = $term->name;
          }
                    
          $on_skill =  join( ", ", $portfolio_skill );
        ?>

          <?php echo balancetags( $on_skill );
endif;

}
