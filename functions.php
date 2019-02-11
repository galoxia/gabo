<?php  

function wpchallenge_setup_theme() {
	// Cargar traducciones
	load_theme_textdomain( 'wpchallenge', get_template_directory() . '/languages' );
	
	add_theme_support( 'title-tag' );

	// Registar el tipo de post "Cuentas"
	$labels = array(
		'name' => esc_html__( 'Cuentas', 'wpchallenge' ),
		'singular_name' => esc_html__( 'Cuenta', 'wpchallenge' ),
		'all_items' => esc_html__( 'Todas las cuentas', 'wpchallenge' ),
		'view_item' => esc_html__( 'Ver cuenta', 'wpchallenge' ),
		'add_new_item' => esc_html__( 'Añadir nueva cuenta', 'wpchallenge' ),
		'add_new' => esc_html__( 'Añadir nueva', 'wpchallenge' ),
		'edit_item' => esc_html__( 'Editar cuenta', 'wpchallenge' ),
		'update_item' => esc_html__( 'Actualizar cuenta', 'wpchallenge' ),
		'search_items' => esc_html__( 'Buscar cuenta', 'wpchallenge' ),
		'not_found' => esc_html__( 'No se encontró ninguna cuenta', 'wpchallenge' ),
		'not_found_in_trash' => esc_html__( 'No se encontró ninguna cuenta en la papelera', 'wpchallenge' )
	);

	$args = array(
		'labels' => $labels,
		'supports' => array( 'title', 'revisions' ),
		'public' => true,
		'menu_icon' => 'dashicons-plus'
	);

	register_post_type( 'cuenta', $args );
}
add_action( 'after_setup_theme', 'wpchallenge_setup_theme' );


function wpchallenge_register_metas() {
	register_meta( 
		'cuenta', 
		'_cuenta_meta_A', 
		array(
			'description' => esc_html__( 'Sumando A', 'wpchallenge' ),
			'type' => 'number',
			'single' => true,
			'sanitize_callback' => 'wpchallenge_sanitize_meta',
		)
	);

	register_meta( 
		'cuenta', 
		'_cuenta_meta_B', 
		array(
			'description' => esc_html__( 'Sumando B', 'wpchallenge' ),
			'type' => 'number',
			'single' => true,
			'sanitize_callback' => 'wpchallenge_sanitize_meta',
		)
	);
}
add_action( 'init', 'wpchallenge_register_metas' );

function wpchallenge_sanitize_meta( $meta_value, $meta_key, $meta_type ) {
	return is_numeric($meta_value)? $meta_value : 0;
}

function wpchallenge_add_cuenta_mb( $post ) {
	add_meta_box( 
		'wpchallenge-cuenta-mb', 
		esc_html__( 'Sumandos de la cuenta', 'wpchallenge' ), 
		'wpchallenge_render_cuenta_mb', 
		'cuenta', 
		'advanced', 
		'high'
	);
}
add_action( 'add_meta_boxes_cuenta', 'wpchallenge_add_cuenta_mb' );

function wpchallenge_render_cuenta_mb( $post, $args = array() ) { 

	$cuenta_meta_A = get_post_meta( $post->ID, '_cuenta_meta_A', true );
	$cuenta_meta_A = empty($cuenta_meta_A)? 0 : $cuenta_meta_A;
	$cuenta_meta_B = get_post_meta( $post->ID, '_cuenta_meta_B', true );
	$cuenta_meta_B = empty($cuenta_meta_B)? 0 : $cuenta_meta_B;

	wp_nonce_field( 'wpchallenge_cuenta_props', 'cuenta_props_nonce' );
?> 

<p>
	<label class="label" for="_cuenta_meta_A"><?php  esc_html_e( 'Sumando A', 'wpchallenge' ); ?></label>
	<input type="text" name="_cuenta_meta_A" id="_cuenta_meta_A" value="<?php echo $cuenta_meta_A; ?>">
</p>

<p>
	<label class="label" for="_cuenta_meta_B"><?php  esc_html_e( 'Sumando B', 'wpchallenge' ); ?></label>
	<input type="text" name="_cuenta_meta_B" id="_cuenta_meta_B" value="<?php echo $cuenta_meta_B; ?>">
</p>

<?php 
}

function wpchallenge_save_cuenta( $post_id, $post ) {
	// Comprueba que el nonce es correcto
	if( ! isset( $_POST['cuenta_props_nonce'] ) || ! wp_verify_nonce( $_POST['cuenta_props_nonce'], 'wpchallenge_cuenta_props' ) )
		return;
	// Guardar los sumandos como custom meta fields asociados a la cuenta
	$props = array( '_cuenta_meta_A', '_cuenta_meta_B' );
	foreach ($props as $value) {
		if( isset( $_POST[$value] ) ){
			update_post_meta( $post_id, $value, $_POST[$value] );
		}
		else
			delete_post_meta( $post_id, $value );
	}
}
add_action( 'save_post_cuenta', 'wpchallenge_save_cuenta', 10, 2 );

function wpchallenge_enqueue_scripts() {
	/* 
	Incluir los estilos del tema padre (twentysixteen). Los estilos del tema hijo son incluidos en el functions.php del tema padre con:
	
	wp_enqueue_style( 'twentysixteen-style', get_stylesheet_uri() );
	*/
	wp_enqueue_style( 'twentysixteen-parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'wpchallenge_enqueue_scripts' );

