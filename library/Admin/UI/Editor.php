<?php

namespace Municipio\Admin\UI;

class Editor
{
    public function __construct()
    {
        // Actions
        add_action('admin_init', array($this, 'editorStyle'));
        add_filter('mce_buttons_2', array($this, 'editorButtons2'));
        add_filter('tiny_mce_before_init', array($this, 'styleFormat'));

        // Custom plugins
        $this->metaData();
        $this->pricons();
        //$this->printBreak();

        // Filters
        add_filter('embed_oembed_html', '\Municipio\Admin\UI\Editor::oembed', 10, 4);

        add_filter('the_content', function ($content) {
            $content = str_replace('<!--printbreak-->', '<div style="page-break-before:always;" class="clearfix print-only"></div>', $content);
            $content = str_replace('<p><div style="page-break-after:before;" class="clearfix print-only"></div></p>', '<div style="page-break-after:before;" class="clearfix print-only"></div>', $content);
            return $content;
        });

        add_filter('tiny_mce_before_init', array($this, 'allowedHtmlTags'));
    }

    /**
     * Extend valid html-elements for wp editor
     * @param  array $init
     * @return array
     */
    public function allowedHtmlTags($init)
    {
        $extend = 'div[*], style[*], script[*], iframe[*], span[*], section[*], article[*], header[*], footer[*]';

        if (isset($init['extended_valid_elements']) && !empty($init['extended_valid_elements'])) {
            $init['extended_valid_elements'] .= ', ' . $extend;
        } else {
            $init['extended_valid_elements'] = $extend;
        }

        return $init;
    }

    /**
     * Add styleselect button to editor
     * @param  array $buttons
     * @return array
     */
    public function editorButtons2($buttons)
    {
        array_unshift($buttons, 'styleselect');
        return $buttons;
    }

    /**
     * Add stylesheet to editor
     * @return void
     */
    public function editorStyle()
    {
        if ((defined('DEV_MODE') && DEV_MODE === true) || (isset($_GET['DEV_MODE']) && $_GET['DEV_MODE'] === 'true')) {
            add_editor_style(apply_filters('Municipio/admin/editor_stylesheet', '//hbgprime.dev/dist/css/hbg-prime-' . \Municipio\Theme\Enqueue::getStyleguideTheme() . '.dev.css'));
            return;
        }

        if (defined('STYLEGUIDE_VERSION') && STYLEGUIDE_VERSION != "") {
            add_editor_style(apply_filters('Municipio/admin/editor_stylesheet', '//helsingborg-stad.github.io/styleguide-web/dist/' . STYLEGUIDE_VERSION . '/css/hbg-prime-' . \Municipio\Theme\Enqueue::getStyleguideTheme() . '.min.css'));
        } else {
            add_editor_style(apply_filters('Municipio/admin/editor_stylesheet', '//helsingborg-stad.github.io/styleguide-web/dist/css/hbg-prime-' . \Municipio\Theme\Enqueue::getStyleguideTheme() . '.min.css'));
        }
    }

    /**
     * Filters oembed output
     * @param  string $data Markup
     * @param  string $url  Embedded url
     * @param  array $args  Args
     * @return string       Markup
     */
    public static function oembed($html, $url, $attr, $postId, $wrapper = true)
    {
        $provider = false;

        if (strpos(strtolower($url), 'youtube') !== false || strpos(strtolower($url), 'youtu.be') !== false) {
            $provider = 'YouTube';
        } elseif (strpos(strtolower($url), 'vimeo') !== false) {
            $provider = 'Vimeo';
        }

        $shouldFilter = apply_filters('Municipio/oembed/should_filter_markup', true, $provider, $url, $postId);

        // Check if there's a oembed class for the provider
        if (!class_exists('\Municipio\Oembed\\' . $provider) || !$shouldFilter) {
            return '<div class="ratio-16-9">' . $html . '</div>';
        }

        $class = '\Municipio\Oembed\\' . $provider;
        $oembed = new $class($url, $html, $wrapper);

        return $oembed->output();
    }

    /**
     * Add style format options
     * @param  array $settings  Options array
     * @return array            Modified options array
     */
    public function styleFormat($settings)
    {
        // Set color scheme class on mce body
        $color = get_field('color_scheme', 'option');

        if ($color) {
            $settings['body_class'] .= ' theme-' . $color;
        }

        // Get style formats
        $styleFormats = self::getEnabledStyleFormats();

        if (empty($styleFormats)) {
            return $settings;
        }

        $settings['style_formats'] = json_encode($styleFormats);
        return $settings;
    }

    /**
     * Get enabled style formats from options
     * @return array
     */
    public static function getEnabledStyleFormats()
    {
        $returnFormats = array();
        $formats = self::getAvailableStyleFormats();
        $enabled = get_field('content_editor_formats', 'options');

        if (is_array($enabled) && !empty($enabled) && is_array($formats) && !empty($formats)) {

            foreach ($formats as $key => &$format) {
                $format = array_filter($format, function ($key) use ($enabled) {
                    return in_array($key, $enabled);
                }, ARRAY_FILTER_USE_KEY);
            }

            foreach ($formats as $key => $items) {
                if (!is_array($items) || count($items) === 0) {
                    continue;
                }

                $returnFormats[] = array(
                    'title' => $key,
                    'items' => $items
                );
            }
        }

        return $returnFormats;
    }

    /**
     * Get available style formats for editor
     * @return array
     */
    public static function getAvailableStyleFormats()
    {
        return apply_filters('Municipio\WpEditor\AvailableFormats', array(
            'Text size' => array(
                'small' => array(
                    'title' => 'Small',
                    'inline' => 'small'
                ),
                'large' => array(
                    'title' => 'Large',
                    'inline' => 'span',
                    'classes' => 'text-lg'
                ),
                'extra-large' => array(
                    'title' => 'Extra large',
                    'inline' => 'span',
                    'classes' => 'text-xl'
                )
            ),

            'Text transform' => array(
                'uppercase' => array(
                    'title' => 'Uppercase',
                    'inline' => 'span',
                    'classes' => 'text-uppercase'
                ),
                'lowercase' => array(
                    'title' => 'Lowercase',
                    'inline' => 'span',
                    'classes' => 'text-lowercase'
                ),
                'capitalize' => array(
                    'title' => 'Capitalize',
                    'inline' => 'span',
                    'classes' => 'text-capitalize'
                )
            ),

            'Highlight' => array(
                'dark-gray' => array(
                    'title' => 'Drak gray',
                    'inline' => 'span',
                    'classes' => 'text-dark-gray'
                ),
                'highlight' => array(
                    'title' => 'Highlight',
                    'inline' => 'span',
                    'classes' => 'text-highlight'
                ),
                'mark' => array(
                    'title' => 'Mark',
                    'inline' => 'mark',
                    'classes' => 'mark'
                ),
                'mark-yellow' => array(
                    'title' => 'Mark yellow',
                    'inline' => 'mark',
                    'classes' => 'mark-yellow'
                ),
                'mark-blue' => array(
                    'title' => 'Mark blue',
                    'inline' => 'mark',
                    'classes' => 'mark-blue'
                ),
                'mark-green' => array(
                    'title' => 'Mark green',
                    'inline' => 'mark',
                    'classes' => 'mark-green'
                ),
                'mark-red' => array(
                    'title' => 'Mark red',
                    'inline' => 'mark',
                    'classes' => 'mark-red'
                ),
                'mark-purple' => array(
                    'title' => 'Mark purple',
                    'inline' => 'mark',
                    'classes' => 'mark-purple'
                ),
            ),

            'Buttons' => array(
                'button' => array(
                    'title' => 'Button',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn'
                ),
                'button-light' => array(
                    'title' => 'Light button',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-light'
                ),
                'button-first' => array(
                    'title' => 'Button: First color',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-theme-first'
                ),
                'button-second' => array(
                    'title' => 'Button: Second color',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-theme-second'
                ),
                'button-third' => array(
                    'title' => 'Button: Third color',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-theme-third'
                ),
                'button-fourth' => array(
                    'title' => 'Button: Fourth color',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-theme-fourth'
                ),
                'button-fifth' => array(
                    'title' => 'Button: Fifth color',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-theme-fifth'
                )
            ),

            'Buttons (outline)' => array(
                'button' => array(
                    'title' => 'Button',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-outline'
                ),
                'button-light' => array(
                    'title' => 'Light button',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-outline btn-light'
                ),
                'button-first' => array(
                    'title' => 'Button: First color',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-outline btn-theme-first'
                ),
                'button-second' => array(
                    'title' => 'Button: Second color',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-outline btn-theme-second'
                ),
                'button-third' => array(
                    'title' => 'Button: Third color',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-outline btn-theme-third'
                ),
                'button-fourth' => array(
                    'title' => 'Button: Fourth color',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-outline btn-theme-fourth'
                ),
                'button-fifth' => array(
                    'title' => 'Button: Fifth color',
                    'inline' => 'a',
                    'block' => 'p',
                    'classes' => 'btn btn-outline btn-theme-fifth'
                )
            )
        ));
    }

    /**
     * Add pricons button to editor
     * @return void
     */
    public function pricons()
    {
        add_filter('mce_external_plugins', function ($plugins) {
            global $pagenow;

            if (!current_user_can('edit_posts') || !current_user_can('edit_pages') || $pagenow != 'post.php') {
                return $plugins;
            }

            $plugins['pricons'] = get_template_directory_uri() . '/assets/dist/' . \Municipio\Helper\CacheBust::name('js/mce-pricons.js');
            return $plugins;
        });

        add_filter('mce_buttons_2', function ($buttons) {
            global $pagenow;

            if (!current_user_can('edit_posts') || !current_user_can('edit_pages') || $pagenow != 'post.php') {
                return $buttons;
            }

            $buttons[] = 'pricons';
            return $buttons;
        });
    }

    /**
     * Metadata plugin
     * @return void
     */
    public function metaData()
    {
        add_action('admin_footer', function () {
            global $pagenow;

            if (!current_user_can('edit_posts') || !current_user_can('edit_pages') || $pagenow != 'post.php') {
                return;
            }

            global $post;
            $metakeys = \Municipio\Helper\Post::getPostMetaKeys($post->ID);

            echo '<script>
                    var metadata_button = [
            ';

            $count = 0;
            foreach ($metakeys as $key => $value) {
                echo "{text: '{$value->meta_key}', value: '[meta key=\"{$value->meta_key}\"]'},";
                $count++;
            }

            echo '];</script>';
        });

        add_filter('mce_external_plugins', function ($plugins) {
            global $pagenow;

            if (!current_user_can('edit_posts') || !current_user_can('edit_pages') || $pagenow != 'post.php') {
                return $plugins;
            }

            $plugins['metadata'] = get_template_directory_uri() . '/assets/dist/' . \Municipio\Helper\CacheBust::name('js/mce-metadata.js');
            return $plugins;
        });

        add_filter('mce_buttons_2', function ($buttons) {
            global $pagenow;

            if (!current_user_can('edit_posts') || !current_user_can('edit_pages') || $pagenow != 'post.php') {
                return $buttons;
            }

            array_splice($buttons, 2, 0, array('metadata'));
            return $buttons;
        });
    }

    /**
     * Metadata plugin
     * @return void
     */
    public function printBreak()
    {
        add_filter('mce_external_plugins', function ($plugins) {
            $plugins['print_break'] = get_template_directory_uri() . '/assets/dist/' . \Municipio\Helper\CacheBust::name('js/mce-print-break.js');
            return $plugins;
        });

        add_filter('mce_buttons', function ($buttons) {
            array_splice($buttons, count($buttons)-2, 0, array('printbreak'));
            return $buttons;
        });
    }
}
