<?php

    class CPT {
        private $name;
        private $key;
        private $desc;
        private $supports;
        private $taxonomies;
        private $icon;
        private $public;
        private $position;
        private $archive;
        private $type;
        private $searchable;
        private $permalink;

        public function __construct() {
            $this -> desc = '';
            $this -> supports = [ 'title', 'editor' ];
            $this -> taxonomies = [];
            $this -> icon = 'dashicons-media-default';
            $this -> public = true;
            $this -> position = 5;
            $this -> archive = true;
            $this -> type = 'page';
            $this -> searchable = true;
        }

        /**
         * Set CPT name and key used from url generation
         *
         * @param string $name
         * @return object
         */

            public function set_name (string $name) {
                $this -> name = $name;
                $this -> key = Helpers::create_slug_from_string($name, '_');

                return $this;
            }

        /**
         * Set CPT description
         *
         * @param string $desc
         * @return object
         */

            public function set_description (string $desc) {
                $this -> desc = __($desc, 'crunch');

                return $this;
            }

        /**
         * Set CPT support
         *
         * @param array $support
         * @return object
         */

            public function set_support (array $support) {
                $this -> supports = $support;

                return $this;
            }

        /**
         * Set CPT taxonomies
         *
         * @param array $tax
         * @return object
         */

            public function set_taxonomies (array $tax) {
                $this -> taxonomies = $tax;

                return $this;
            }

        /**
         * Set CPT icon
         *
         * @param string $icon
         * @return object
         */

            public function set_icon (string $icon) {
                $this -> icon = $icon;

                return $this;
            }

        /**
         * Set CPT visibility
         *
         * @param boolean $public
         * @return boolean
         */

            public function is_public (bool $public) {
                $this -> public = $public;

                return $this;
            }

        /**
         * Set CPT position in menu
         *
         * @param integer $position
         * @return object
         */

            public function set_position (int $position) {
                $this -> position = $position;

                return $this;
            }

        /**
         * Set CPT archive
         *
         * @param boolean $archive
         * @return boolean
         */

            public function has_archive (bool $archive) {
                $this -> archive = $archive;

                return $this;
            }

        /**
         * Set CPT capability type
         *
         * @param string $type
         * @return object
         */

            public function set_type (string $type) {
                $this -> type = $type;

                return $this;
            }


        /**
         * Determines whether CPT is searchable
         *
         * @param boolean $searchable
         * @return object
         */

            public function is_searchable (bool $searchable) {
                $this -> searchable = !$searchable;

                return $this;
            }

        /**
         * Set CPT custom permalink
         *
         * @param string $slug
         * @return object
         */

            public function set_permalink (string $slug) {
                $this -> permalink = $slug;

                return $this;
            }

        /**
         * Run CPT registration process
         *
         * @return object
         */

            public function register () {
                add_action(
                    'init',
                    function () {
                        $args = [
                            'public'                => $this -> public,
                            'label'                 => $this -> name,
                            'description'           => $this -> desc,
                            'supports'              => $this -> supports,
                            'taxonomies'            => $this -> taxonomies,
                            'menu_icon'             => $this -> icon,
                            'menu_position'         => $this -> position,
                            'has_archive'           => $this -> archive,
                            'capability_type'       => $this -> type,
                            'exclude_from_search'   => $this -> searchable,
                            'rewrite'               => [
                                'slug'                  => $this -> permalink,
                                'with_front'            => true,
                                'pages'                 => true,
                                'feeds'                 => true,
                            ]
                        ];

                        register_post_type( $this -> key, $args );
                    }
                );
            }

    }
