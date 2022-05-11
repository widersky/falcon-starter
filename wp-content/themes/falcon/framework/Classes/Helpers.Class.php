<?php

/**
 * Helpers class
 *
 * Helpers for global use
 */
class Helpers {

    /**
     * Create simple slug from given string
     *
     * @param String Text for transform
     * @param Divider (optional) Slug words delimiter
     */

        public static function create_slug_from_string (string $string, string $divider = '-') {
            $string = preg_replace('~[^\pL\d]+~u', $divider, $string);
            $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
            $string = preg_replace('~[^-\w]+~', '', $string);
            $string = trim($string, $divider);
            $string = preg_replace('~-+~', $divider, $string);
            $string = strtolower($string);
            if (empty($string)) {
                return 'n-a';
            }

            return $string;
        }

    /**
     * Nicely show PHP object / array
     *
     * @param What
     */

        public static function dump ($what) {
            echo '<pre>' . print_r($what, true) . '</pre>';
        }

}
