<?php

    require get_template_directory() . "/framework/config.php";
    require get_template_directory() . "/framework/Classes/Helpers.Class.php";
    require get_template_directory() . "/framework/Classes/Block.Class.php";
    require get_template_directory() . "/framework/Classes/CPT.Class.php";
    require get_template_directory() . "/framework/Classes/BlocksLoader.Class.php";
    require get_template_directory() . "/framework/Classes/Optimize.Class.php";

    // Create custom blocks for pages
    $blocks = new BlocksLoader();
    $blocks -> register_category('Dostępne bloki');
    $blocks -> allow_in(['page']);
    $blocks -> add('banner');
    $blocks -> add('faq');
    $blocks -> load();
    
    // Add SVG files to upload
    add_filter('upload_mimes', function ($fileTypes) {
        $fileTypes['svg'] = 'image/svg+xml';
        return $fileTypes;
    }, 1, 1);
    
    // Additional thumbnails sizes (name, x, y, hardmode?)
    add_image_size('size-4k', '3840', '2160', true);
    add_image_size('size-qhd', '2560', '1440', true);
    add_image_size('size-fullhd', '1920', '1080', true);
    add_image_size('size-hd', '1366', '768', true);
    add_image_size('size-xga', '1024', '768', true);
    add_image_size('size-svga', '800', '600', true);
    add_image_size('size-small', '640', '480', true);
    add_image_size('size-verysmall', '320', '240', true);
    
    // Register global styles and scripts
    add_action('wp_enqueue_scripts', function () {
        $css_version = date("ymd-Gis", filemtime(get_template_directory() . '/dist/css/main.css'));
        $js_version = date("ymd-Gis", filemtime(get_template_directory() . '/dist/js/main.js'));
    
        $mainCSS = get_template_directory_uri() . '/dist/css/main.css';
        $mainJS = get_template_directory_uri() . '/dist/js/main.js';
    
        wp_enqueue_style('styles', $mainCSS, $css_version, true);
        wp_enqueue_script('scripts', $mainJS, $js_version, true);
    });

    // Add title tag support
    add_theme_support('title-tag');

    // Enable post thumbnails in theme
    add_theme_support('post-thumbnails'); 

    // Register custom menus
    register_nav_menus(array(
        'top'    => __('Główne menu', 'falcon'),
        'footer' => __('Menu w stopce', 'falcon')
    ));
    
    // Optimize WP by disabling unnecessary functions
    $optimize = new Optimize();
    $optimize -> disable_gutenberg_styles();
    $optimize -> disable_xml_rpc();
    $optimize -> disable_wp_embed();
    $optimize -> clean_mess_in_head();
    $optimize -> webpize_image_uploads();
    $optimize -> move_scripts_to_footer();
    $optimize -> clean_admin_panel();

    // Add theme options page
    if( function_exists('acf_add_options_page') ) {
    
        acf_add_options_page(array(
            'page_title' 	=> 'Opcje',
            'menu_title'	=> 'Opcje',
            'menu_slug' 	=> 'theme-settings',
            'capability'	=> 'edit_posts',
            'redirect'		=> false
        ));
        
    }