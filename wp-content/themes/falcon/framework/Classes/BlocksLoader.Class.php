<?php

/**
 * Gutenberg Blocks Loader
 *
 * Load Gutenberg blocks easily
 */
class BlocksLoader {
    public $type;
    public $categoryName;
    private $categorySlug;
    private $blocksStack;
    private $blocksPath;
    private $allowedBlocks;
    private $cpts;

    public function __construct () {
        $this -> type = 'full-width';
        $this -> blocksStack = [];
        $this -> categoryName;
        $this -> categorySlug = '';
        $this -> blocksPath = get_stylesheet_directory() . '/partials/blocks';
        $this -> allowedBlocks = [];
        $this -> cpts = [ 'post', 'page' ];
    }

    /**
     * Set block type - full-width or inner
     *
     * @param string Block type
     */

        public function set_type (string $type) {
            $this -> type = $type;
        }

    /**
     * Register custom category for blocks
     *
     * @param Name category name
     */

        public function register_category (string $name) {
            $this -> categoryName = $name;
            $this -> categorySlug = Helpers::create_slug_from_string($this -> categoryName);

            add_filter('block_categories', function ($categories, $post) {
                return array_merge(
                    $categories,
                    [[
                        'slug'  => $this -> categorySlug,
                        'title' => $this -> categoryName,
                        'icon'  => ''
                    ]]
                );
            }, 10, 2);
        }

    /**
     * If we don't want to create custom category, this method allows us to use default one
     *
     * @param string slug of one of the default categories
     */

        public function use_default_category (string $slug) {
            $this -> categorySlug = $slug;
        }

    /**
     * Get specified block config from JSON file
     *
     * @param string Slug Block slug
     * @return Array
     */

        private function get_config (string $slug) {
            $JSON_location = $this -> blocksPath . '/' . $this -> type . '/' . $slug . '/' . $slug . '.json';
            $JSON_config = file_exists($JSON_location);

            if (!$JSON_config) return false;

            $decoded_config = json_decode(file_get_contents($JSON_location));

            $config = [
                'title'                     => $decoded_config -> title,
                'description'               => $decoded_config -> description,
                'icon'                      => $decoded_config -> icon,
                'keywords'                  => $decoded_config -> keywords,
                'enqueue_styles'            => $decoded_config -> styles,
                'enqueue_scripts'           => $decoded_config -> scripts,
            ];

            return $config;
        }

    /**
     * Allow block only in selected post types
     *
     * @param array $cpts_slugs
     * @return void
     */

        public function allow_in (array $cpts_slugs) {
            $this -> cpts = $cpts_slugs;
        }

    /**
     * Adds block to load stack
     *
     * @param string slug Block slug
     */

        public function add (string $slug) {
            $blockConfig = $this -> get_config($slug);

            if ($blockConfig === false) {
                throw new Exception('There is no config file in ' . $slug . ' block!');
            }

            $snakeSlug = Helpers::create_slug_from_string($slug, '_');
            $enqueueStyles = $blockConfig['enqueue_styles'];
            $enqueueScripts = $blockConfig['enqueue_scripts'];

            $baseBlockConfig = [
                'name'              => $slug,
                'render_template'   => 'partials/blocks/' . $this -> type . '/' . $slug . '/' . $slug . '.php',
                'mode'              => 'edit', // preview / edit / auto
                'category'          => $this -> categorySlug,
                'post_types'        => $this -> cpts,
                'example'           => [
                    'attributes'        => [
                        'mode'              => 'preview',
                        'data'              => [
                            'is_preview'        => true,
                            'preview_img'       => get_stylesheet_directory_uri() . '/partials/blocks/' . $this -> type . '/' . $slug . '/' . $slug . '.jpg',
                        ]
                    ]  
                ],
                'supports'          => [
                    'align_content' => false,
                    'align'         => false,
                    'mode'          => false
                ],
                'enqueue_assets'    => function () use ($slug, $snakeSlug, $enqueueStyles, $enqueueScripts) {

                    // Styles
                    if ($enqueueStyles) {
                        $block_styles_uri = 'dist/css/block-' . $snakeSlug . '.css';
                        $block_styles_ver = date("ymd-Gis", filemtime(get_stylesheet_directory() . '/' . $block_styles_uri));

                        wp_enqueue_style($slug . '-block-styles', get_stylesheet_directory_uri() . '/' . $block_styles_uri, [], $block_styles_ver, 'all');
                    }

                    // Scripts
                    if ($enqueueScripts) {
                        $block_scripts_uri = 'dist/js/block-' . $snakeSlug . '.js';
                        $block_scripts_ver = date("ymd-Gis", filemtime(get_stylesheet_directory() . '/' . $block_scripts_uri));
                        
                        wp_enqueue_script($slug . '-block-scripts', get_stylesheet_directory_uri() . '/' . $block_scripts_uri, [], $block_scripts_ver, true);
                    }

                },
            ];

            $this -> blocksStack[] = array_merge($baseBlockConfig, $blockConfig);
        }

    /**
     * Loads every block that was set by add() method
     */

        public function load () {
            if (function_exists('acf_register_block_type')) {
                add_action('acf/init', function () {
                    foreach ($this -> blocksStack as $block) {
                        acf_register_block_type($block);
                    }
                });

                add_filter('allowed_block_types_all', function () {
                    foreach ($this -> blocksStack as $block) {
                        $this -> allowedBlocks[] = 'acf/' . $block['name'];
                    }

                    return $this -> allowedBlocks;
                }, 10, 2);
            }
        }
}
