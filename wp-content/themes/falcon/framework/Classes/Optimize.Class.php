<?php

    class Optimize
    {


        /**
         * Disable default gutenberg blocks styles (- ~79KB)
         *
         * @return void
         */
        public function disable_gutenberg_styles () {
            add_action( 'wp_print_styles', function () {
                wp_dequeue_style('wp-block-library');
                wp_dequeue_style('wp-block-library-theme');
                wp_dequeue_style('wc-block-style');             // Remove WooCommerce blocks CSS
                wp_dequeue_style('global-styles');              // Remove theme.json
            }, 100 );
        }


        /**
         * Disable XML-RPC
         *
         * @return void
         */
        public function disable_xml_rpc () {
            add_filter('xmlrpc_enabled', '__return_false');
            remove_action('wp_head', 'rsd_link');
            remove_action('wp_head', 'wlwmanifest_link');
        }


        /**
         * Remove WP Embed from footer
         *
         * @return void
         */
        public function disable_wp_embed () {
            add_action('wp_footer', function () {
                wp_deregister_script('wp-embed');
            });
        }


        /**
         * Remove emojis from WP frontend (-18KB)
         *
         * @return void
         */
        public function remove_emojis () {
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('admin_print_scripts', 'print_emoji_detection_script');
            remove_action('wp_print_styles', 'print_emoji_styles');
            remove_action('admin_print_styles', 'print_emoji_styles');
            remove_filter('the_content_feed', 'wp_staticize_emoji');
            remove_filter('comment_text_rss', 'wp_staticize_emoji');
            remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        }


        /**
         * Clean head section from unnecessary code
         *
         * @return void
         */
        public function clean_mess_in_head () {
            remove_action('wp_head', 'rsd_link');                                   // Windows Live Writer remove
            remove_action('wp_head', 'wlwmanifest_link');                           // Windows Live Writer remove
            remove_action('wp_head', 'wp_generator');                               // Remove WP version
            remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );               // removes rel=shortlink from head that google ignores
            remove_action('wp_head', 'feed_links', 2);                              // remove RSS feed links
            remove_action('wp_head', 'feed_links_extra', 3);                        // removes all extra RSS feed links
            remove_action('wp_head', 'index_rel_link');                             // remove link to index page
            remove_action('wp_head', 'start_post_rel_link', 10, 0);                 // remove random post link
            remove_action('wp_head', 'parent_post_rel_link', 10, 0);                // remove parent post link
            remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);             // remove the next and previous post links
        }
        
        
        /**
         * Convert image files to webp format
         *
         * @return $file Original file or converted one
         */
        public function webpize_image_uploads () {
            add_filter("wp_handle_upload_prefilter", function ( $file ) {
                if (getimagesize( $file['tmp_name'] )) {
                    $image_file = file_get_contents( $file['tmp_name'] );
                    $image_file = imagecreatefromstring( $image_file );
                    
                    if ( $image_file !== false ) {
                        $converted_image = imagewebp( $image_file, $file['tmp_name'] );
                        
                        if ( $converted_image ) {
                            $file['name'] = explode( '.', $file['name'] )[0] . '.webp';
                        }
                    }
                }
                
                return $file;
            });
        }
        
        
        public function move_scripts_to_footer () {
            add_action('init', function () {
                remove_action('wp_head', 'wp_print_scripts');
                remove_action('wp_head', 'wp_print_head_scripts', 9);
                add_action('wp_footer', 'wp_print_scripts', 5);
                add_action('wp_footer', 'wp_print_head_scripts', 5);
            });
        }
        
        
        public function clean_admin_panel () {
            add_action( 'admin_menu', function () {
                remove_menu_page('edit-comments.php');
                remove_menu_page('tools.php');
                remove_submenu_page('plugins.php', 'plugin-editor.php');
                remove_submenu_page('themes.php', 'theme-editor.php');
                remove_submenu_page('themes.php', 'customize.php?return=%2Fwp-admin%2Fedit.php%3Fpost_type%3Dacf-field-group');
                remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
                
                // Remove ACF builder page for users other than superadmin
                if (is_admin() && get_current_user_id() != '1') {
                    remove_menu_page('edit.php?post_type=acf-field-group');
                }
            }, 999 );
        }

    }
