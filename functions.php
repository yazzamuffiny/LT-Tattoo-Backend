<?php

  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo');

  function add_cors_http_header() {header("Access-Control-Allow-Origin: *");}
  add_action('init', 'add_cors_http_header');

  function enqueue_parent_and_custom_styles() {
      // Enqueue parent theme styles
      wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    
      // Enqueue custom styles
      wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/custom.css', array('parent-style'));
  }

  add_action('wp_enqueue_scripts', 'enqueue_parent_and_custom_styles');
  

  // Customizer Settings
  // Use the WordPress Customization API to register these customizer settings
  function custom_theme_customize_register( $wp_customize ) {

// Font family setting
      // change font family
      $wp_customize->add_section('fonts', array(
          'title' => __('Fonts', 'custom-theme'),
          'priority' => 30,
      ));

      $wp_customize->add_setting('font_family', array(
          'default' => 'New Rocker', 
          'transport' => 'postMessage',
      ));

      // Add a control for font family
      $wp_customize->add_control('font_family_control', array(
          'label'    => 'Font Family',
          'section'  => 'fonts',
          'settings' => 'font_family',
          'type'     => 'select',
          'choices'  => array(
			'New Rocker' => 'New Rocker',
            'UnifrakturCook'     => 'UnifrakturCook',
            'Pirata One' => 'Pirata One',
            'Fondamento' => 'Fondamento',
          ),
      ));

    //primary button color
    $wp_customize->add_setting('primary_button_color', array(
        'default' => '#9A0404',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_button_color', array(
        'label' => __('Primary Button Color', 'custom-theme'),
        'section' => 'colors',
    )));

    //primary button font color
    $wp_customize->add_setting('primary_button_font_color', array(
        'default' => '#ffffff',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_button_font_color', array(
        'label' => __('Primary Button Font Color', 'custom-theme'),
        'section' => 'colors',
    )));

    //secondary button color
    $wp_customize->add_setting('secondary_button_color', array(
        'default' => '#9A0404',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_button_color', array(
        'label' => __('Secondary Button Color', 'custom-theme'),
        'section' => 'colors',
    )));

    //social icon color
    $wp_customize->add_setting('social_icon_color', array(
      'default' => '#9A0404',
      'transport' => 'postMessage',
  ));

  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'social_icon_color', array(
      'label' => __('Social Icon Color', 'custom-theme'),
      'section' => 'colors',
  )));

    //line color
    $wp_customize->add_setting('line_color', array(
      'default' => '#9A0404',
      'transport' => 'postMessage',
  ));

  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'line_color', array(
      'label' => __('Image Line Color', 'custom-theme'),
      'section' => 'colors',
  )));

      //footer line color
      $wp_customize->add_setting('footer_line_color', array(
        'default' => '#9A0404',
        'transport' => 'postMessage',
    ));
  
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_line_color', array(
        'label' => __('Footer Line Color', 'custom-theme'),
        'section' => 'colors',
    )));


    //end customizer settings
    }


  add_action( 'customize_register', 'custom_theme_customize_register' );

  
  // Custom REST API endpoint to retrieve customizer settings
  function get_customizer_settings() {
    $settings = array(
      'fontFamily' => get_theme_mod('font_family', 'New Rocker, system-ui'),
      'primaryButtonColor' => get_theme_mod('primary_button_color', '#9A0404'),
      'primaryButtonFontColor' => get_theme_mod('primary_button_font_color', '#ffffff'),
      'secondaryButtonColor' => get_theme_mod('secondary_button_color', '#9A0404'),
      'socialIconColor' => get_theme_mod('social_icon_color', '#9A0404'),
      'lineColor' => get_theme_mod('line_color', '#9A0404'),
      'footerLineColor' => get_theme_mod('footer_line_color', '#9A0404'),
    );
  
    return rest_ensure_response($settings);
  }

  add_action('rest_api_init', function () {
    register_rest_route('custom-theme/v1', '/customizer-settings', array(
      'methods' => 'GET',
      'callback' => 'get_customizer_settings',
    ));
  });


  function get_nav_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    
    return $logo;
  }

  add_action('rest_api_init', function () {
      register_rest_route('custom/v1', 'nav-logo', array(
          'methods' => 'GET',
          'callback' => 'get_nav_logo',
      ));
  });
         
?>