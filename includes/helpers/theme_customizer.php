<?php
add_action( 'customize_register', 'hcc_customizer_init' );
function hcc_customizer_init( $wp_customize ) {
    $hcc_transport = 'postMessage';
    
    $wp_customize->add_section(
		'hcc_display_options',
		array(
			'title'     => __('Відображення', 'hcc'),
			'priority'  => 200,
			'description' => __('Налаштуйте зовнішній вигляд Вашого сайту', 'hcc'),
		)
	);
    $wp_customize->add_section(
		'hcc_advanced_options',
		array(
			'title'     => __('Налаштування фону', 'hcc'),
			'priority'  => 201
		)
	);
    //Header display
    $wp_customize->add_setting(
		'hcc_display_header', // id
		array(
			'default'    =>  'true',
			'transport'  =>  $hcc_transport
		)
	);
    $wp_customize->add_control(
		'hcc_display_header', // id
		array(
			'section'   => 'hcc_display_options',
			'label'     => __('Показати заголовок сайту?', 'hcc'),
			'type'      => 'checkbox'
		)
	);
    //Color scheme
    $wp_customize->add_setting(
		'hcc_color_scheme', // id
		array(
			'default'   => 'normal',
			'transport' => $hcc_transport
		)
	);
	$wp_customize->add_control(
		'hcc_color_scheme', // id
		array(
			'section'  => 'hcc_display_options',
			'label'    => __('Кольорова схема', 'hcc'),
			'type'     => 'radio',
			'choices'  => array(
				'normal'    => 'Светлая',
				'inverse'   => 'Темная'
			)
		)
	);
    //Fonts
    $wp_customize->add_setting(
		'hcc_font', // id
		array(
			'default'   => 'arial',
			'type'      => 'theme_mod',
			'transport' => $hcc_transport
		)
	);
	$wp_customize->add_control(
		'true_font', // id
		array(
			'section'  => 'hcc_display_options', // секция
			'label'    => __('Шрифт','hcc'),
			'type'     => 'select',
			'choices'  => array(
				'arial'     => 'Arial',
				'courier'   => 'Courier New'
			)
		)
	);
    //Backgrounds
    $wp_customize->add_setting(
		'hcc_background_image',
		array(
			'default'      => '',
			'transport'    => $hcc_transport
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'hcc_background_image',
			array(
				'label'    => __('Фон сайтy','hcc'),
				'settings' => 'hcc_background_image',
				'section'  => 'hcc_advanced_options'
			)
		)
	);
    $wp_customize->add_setting(
		'hcc_header_background_image',
		array(
			'default'      => '',
			'transport'    => $hcc_transport
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'hcc_header_background_image',
			array(
				'label'    => __('Фон заголовка сайтy','hcc'),
				'settings' => 'hcc_header_background_image',
				'section'  => 'hcc_advanced_options'
			)
		)
	);
    //Link colors
    $wp_customize->add_setting(
		'hcc_link_color', // id
		array(
			'default'     => '#000000',
			'transport'   => $hcc_transport
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hcc_link_color', // id
			array(
			    'label'      => __('Колір посилань', 'hcc'),
			    'section'    => 'colors',
			    'settings'   => 'hcc_link_color' // id
			)
		)
	);
}

add_action( 'get_footer', 'hcc_customizer_css' );
function hcc_customizer_css() {
    echo '<style>';
	echo 'body {font-family:';
	switch( get_theme_mod( 'hcc_font' ) ) {
		case 'arial':
			echo 'Arial, Helvetica, sans-serif;';
			break;
		case 'courier':
			echo '\'Courier New\', Courier;';
			break;
		default:
			echo 'Arial, Helvetica, sans-serif;';
			break;
	}
	if ( 'inverse' == get_theme_mod( 'hcc_color_scheme' ) ) { 
		echo 'background-color:#000;color:#fff;'; // черный фон, белый текст
	} else {
		echo 'background-color:#fff;color:#000;'; // белый фон, черный текст
	}
	if ( 0 < count( strlen( ( $background_image_url = get_theme_mod( 'hcc_background_image' ) ) ) ) ) {
    		echo 'background-image: url( \'' . $background_image_url . '\' );';
	}
	echo '}'; 
 
	//Links
	echo 'a { color: ' . get_theme_mod( 'hcc_link_color' ) . '; }';
 
	//Header
	if( false === get_theme_mod( 'hcc_display_header' ) ) {
		echo '#header { display: none; }';
	}
	if ( 0 < count( strlen( ( $background_image_url = get_theme_mod( 'hcc_header_background_image' ) ) ) ) ) {
    		echo 'background-image: url( \'' . $background_image_url . '\' );';
	}
	echo '}'; 
    echo '</style>';
    
}