<?php 
/*
* @package ablog-theme.
* 根据bootstrap 分页函数演化而来 
*/

function wp_boostrap_4_pagination(){


    if( is_singular() )
        return;
 
    global $wp_query;
 
    /** Check number of pages **/
    if( $wp_query->max_num_pages <= 1 )
        return;
 
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
 
    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;
 
    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
 
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
 
    echo '<div class="row">' . "\n";
 
    /** Previous Post Link */
    if ( get_previous_posts_link() )
      //%s 是占位符代表的是下面第一个变量也就是链接获取函数
        printf( '<div class="col-md-4 col-xs-2">%s</div>' . "\n", get_previous_posts_link('<img src="'. get_theme_file_uri( '/images/left-botton.png' ) .'" alt="left-button">') );
      echo '<div class="col-md-4 col-xs-8 text-center">';
      echo '<ul class="page-nav text-center list-inline">';
 
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="list-inline-item active"' : ' class="list-inline-item"';
 
        printf( '<li%s><a class="abt-page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
 
        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="list-inline-item active"' : ' class="list-inline-item"';
        printf( '<li%s><a class="abt-page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
 
    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";
 
        $class = $paged == $max ? ' class="list-inline-item active"' : ' class="list-inline-item"';
        printf( '<li%s><a class="abt-page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
    echo '</ul>';
    echo '</div>';
 
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<div class="col-md-4 col-xs-2 text-right">%s</div>' . "\n", get_next_posts_link( '<img src="'. get_theme_file_uri( '/images/right-button.png' ) .'" alt="right-button">') );
 
    echo '</div>' . "\n";
 
}


/*
* Custom Attribute for links
*/

add_filter('next_posts_link_attributes', 'wp_boostrap_4_pagination_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'wp_boostrap_4_pagination_posts_link_attributes');

function wp_boostrap_4_pagination_posts_link_attributes() {
    return 'class="left-button"';
}