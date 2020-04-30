<?php

/*
Plugin Name: Wp Bootstrap Carousel
Plugin URI: https://github.com/alexanderkulnyow/wp_bootstrap_carousel
Description: A brief description of the Plugin.
Version: 1.0
Author: Alexander Kulnyow
Author URI: http://alexanderkulnyow.github.io
License: A "Slug" license name e.g. GPL2
*/


/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/

if ( ! defined( 'RC_WpBC_BASE_FILE' ) ) {
	define( 'RC_WpBC_BASE_FILE', __FILE__ );
}
if ( ! defined( 'RC_WpBC_BASE_DIR' ) ) {
	define( 'RC_WpBC_BASE_DIR', dirname( RC_WpBC_BASE_FILE ) );
}
if ( ! defined( 'RC_WpBC_PLUGIN_URL' ) ) {
	define( 'RC_WpBC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/*
|--------------------------------------------------------------------------
| FILTERS
|--------------------------------------------------------------------------
*/

add_filter( 'template_include', 'rc_WpBC_template_chooser' );


/*
|--------------------------------------------------------------------------
| DEFINE THE CUSTOM POST TYPE
|--------------------------------------------------------------------------
*/

add_action( 'init', 'dds_bootstrap_carousel' ); // Использовать функцию только внутри хука init
function dds_bootstrap_carousel() {
	$labels = array(
		'name'               => 'Carousel',
		'singular_name'      => 'Slide', // админ панель Добавить->Функцию
		'add_new'            => 'Add slide',
		'add_new_item'       => 'Add new slide', // заголовок тега <title>
		'edit_item'          => 'Edit slide',
		'new_item'           => 'New slide',
		'all_items'          => 'All slides',
		'view_item'          => 'View slide',
		'search_items'       => 'Search slides',
		'not_found'          => 'Slide not found',
		'not_found_in_trash' => 'Not found in trash',
		'menu_name'          => 'Carousel' // ссылка в меню в админке
	);
	$args   = array(
		'labels'          => $labels,
		'public'          => true, // благодаря этому некоторые параметры можно пропустить
		'menu_icon'       => 'dashicons-images-alt', // иконка корзины
		'rewrite'         => array( 'slug' => 'bts-slide', 'with_front' => true ),
		'capability_type' => 'post',
		'menu_position'   => 5,
		'has_archive'     => true,
		'show_in_rest'    => true,
		'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'taxonomies'      => array( 'post_tag' )
	);
	register_post_type( 'bootstrap_carousel', $args );

}

/*
|--------------------------------------------------------------------------
| PLUGIN FUNCTIONS
|--------------------------------------------------------------------------
*/

/**
 * Returns template file
 *
 * @since       1.0
 */

function rc_WpBC_template_chooser( $template ) {

	// Post ID
	$post_id = get_the_ID();

	// For all other CPT
	if ( get_post_type( $post_id ) != 'bts-slide' ) {
		return $template;
	}

	// Else use custom template
	if ( is_single() ) {
		return rc_WpBC_get_template_hierarchy( 'single' );
	}

}

/**
 * Get the custom template if is set
 *
 * @since       1.0
 */

function rc_WpBC_get_template_hierarchy( $template ) {

	// Get the template slug
	$template_slug = rtrim( $template, '.php' );
	$template      = $template_slug . '.php';

	// Check if a custom template exists in the theme folder, if not, load the plugin template file
	if ( $theme_file = locate_template( array( 'plugin_template/' . $template ) ) ) {
		$file = $theme_file;
	} else {
		$file = RC_WpBC_BASE_DIR . '/includes/templates/' . $template;
	}

	return apply_filters( 'rc_repl_template_' . $template, $file );
}


/**
 * carousel
 *
 * @since       1.0
 */
function some(){


?>

<div id="wp_bootstrap_carousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
		<?php
		$args  = array(
			'post_type' => 'slides1',
			'orderby'   => 'menu_order title',
			'order'     => 'ASC',
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) :
			$i = 0;
			while ( $query->have_posts() ) : $query->the_post();
				echo "<li data-target='#carouselExampleIndicators' data-slide-to=' " . $i . " ' class='<?php if( $i === 0 ):?> active <?php  endif; ?>'></li>";
				$i ++;
			endwhile;
		 endif;
		?>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="..." class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div id="Wp_Bootstrap_Carousel" class="carousel slide" data-ride="carousel">

    <ol class="carousel-indicators">
		<?php
		$args  = array(
			'post_type' => 'bootstrap_carousel',
			'orderby'   => 'menu_order title',
			'order'     => 'ASC',
		);
		$query = new WP_Query( $args );
		?>
		<?php if ( $query->have_posts() ) : ?>
			<?php $i = 0; ?>
			<?php while ( $query->have_posts() ) : $query->the_post() ?>
                <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i ?>"
                    class="<?php if ( $i === 0 ): ?>active<?php endif; ?>"></li>
				<?php $i ++; ?>
			<?php endwhile ?>
		<?php endif ?>
		<?php wp_reset_postdata(); ?>
    </ol>

    <div class="carousel-inner" role="listbox">
		<?php
		$args  = array(
			'post_type' => 'slides1',
			'orderby'   => 'menu_order title',
			'order'     => 'ASC',
		);
		$query = new WP_Query( $args );
		?>
		<?php if ( $query->have_posts() ) : ?>
			<?php $i = 0; ?>
			<?php while ( $query->have_posts() ) : $query->the_post() ?>
                <div class="item <?php if ( $i === 0 ): ?>active<?php endif; ?>">
                    <img src="<?php the_field( 'slide_image' ); ?>" alt="">
                </div>
				<?php $i ++; ?>
			<?php endwhile ?>
		<?php endif ?>
		<?php wp_reset_postdata(); ?>

    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<?php
}
