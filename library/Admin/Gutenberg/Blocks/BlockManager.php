<?php
namespace Municipio\Admin\Gutenberg\Blocks;

class BlockManager {

    /* These block works fine without validation */
    private $noValidationRequired = [
        'acf/button',
        'acf/innerbutton',
    ];

    public function __construct() {
        add_filter('Municipio/blade/view_paths', array($this, 'getViewPath'), 10);
        add_action('init', array($this, 'registerBlocks'), 10);
    }

    /**
     * Register blocks
     *
     * @return void
     */
    public function registerBlocks() {
        // Check function exists.
        if (function_exists('acf_register_block_type')) {
            // register a button block.
            acf_register_block_type(array(
                'name'              => 'button',
                'title'             => __('Button', 'municipio'),
                'description'       => __('A button block', 'municipio'),
                'render_callback'   => array($this, 'renderCallback'),
                'category'          => 'formatting',
                'icon'              => 'button',
                'keywords'          => array('button', 'link'),
                'supports'          => [
                    'align' => true,
                    'jsx' => true
                ],
                'view'              => 'button'
            ));

            // register a button block (inner).
            acf_register_block_type(array(
                'name'              => 'innerButton',
                'title'             => __('Button (Inner)', 'municipio'),
                'description'       => __('A button block', 'municipio'),
                'render_callback'   => array($this, 'renderCallback'),
                'category'          => 'formatting',
                'icon'              => 'button',
                'keywords'          => array('button', 'link'),
                'parent'            => ['acf/button'],
                'supports'          => [
                    'align' => false,
                    'jsx' => true
                ],
                'view'              => 'button'
            ));

            acf_register_block_type(array(
                'name'              => 'classic',
                'title'             => __('Classic', 'municipio'),
                'description'       => __('A block that lets you create and edit articles', 'municipio'),
                'render_callback'   => array($this, 'renderCallback'),
                'category'          => 'formatting',
                'icon'              => 'text',
                'keywords'          => array('editor', 'classic'),
                'supports'          => [
                    'align' => true
                ],
                'view'              => 'classic'
            ));
        }
    }

    /**
     * Callback for block, renders view.
     *
     * @param array $block
     * @return void
     */
    public function renderCallback($block) {
        $data = $this->buildData($block['data']);
        $data['blockType'] = $block['name'];
        $data['classList'] = $this->buildBlockClassList($block);

        if ($this->validateFields($block['data']) || in_array($block['name'], $this->noValidationRequired)) {
            echo render_blade_view($block['view'], $data);
        } else {
            echo render_blade_view('default', ['blockTitle' => $block['title'], 'message' => __('Please fill in all required fields.', 'municipio')]);
        }
    }

    /**
     * Return the general view path
     *
     * @param array $paths
     * @return array
     */
    public function getViewPath($paths) {
        $paths[] = plugin_dir_path(__FILE__) . 'views';
        return $paths;
    }

    /**
     * Builds data to view.
     *
     * @param array $data
     * @return array
     */
    public function buildData($data) {
        $newData = [];
        foreach ($data as $key => $value) {
            $key = ltrim($key, '_');
            $newValue = get_field($value);

            if (str_contains($value, 'field_')) {
                $newData[$key] = get_field($value);
            } else {
                $newData[get_field_object($key)['name']] = $value;
            }
        }

        return $newData;
    }

    /**
     * Build block classlist
     *
     * @param [type] $block
     * @return void
     */
    public function buildBlockClassList($block)
    {
        $classList = ['t-block-container'];

        if (in_array($block['name'], ['acf/button'])) {
            $classList[] = "t-block-button"; 
        }

        if (isset($block['align']) && !empty($block['align'])) {
            $classList[] = "t-block-align-" . $block['align'];
        }

        return implode(' ', $classList);
    }

    /**
     * Validates the required fields
     * @return boolean
     */
    private function validateFields($fields) {

        $valid = true;

        foreach ($fields as $key => $value) {

            if (is_string($key) && is_string($value)) {
                if (str_contains($key, 'field_')) {
                    $field = $key;
                } elseif (str_contains($value, 'field_')) {
                    $field = $value;
                }
            }

            $fieldObject = get_field_object($field);
            //Skip validation of decendants
            if (isset($fieldObject['parent']) && str_contains($fieldObject['parent'], 'field_')) {
                continue;
            }

            //Check if required field has a value
            if($fieldObject['required'] && (!$fieldObject['value'] && $fieldObject['value'] !== "0")) {
                $valid = false;
            }
        }

        return $valid;
    }
}