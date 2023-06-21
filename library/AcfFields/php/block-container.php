<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_63cfdba21f7fc',
    'title' => __('Container Block', 'municipio'),
    'fields' => array(
        0 => array(
            'key' => 'field_63cfdba39a6d2',
            'label' => __('Amount of padding', 'municipio'),
            'name' => 'amount',
            'type' => 'range',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'aria-label' => '',
            'default_value' => 4,
            'min' => 0,
            'max' => 24,
            'step' => '',
            'prepend' => '',
            'append' => '',
        ),
        1 => array(
            'key' => 'field_644b6d221b7a4',
            'label' => __('Content width', 'municipio'),
            'name' => 'content_width',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'aria-label' => '',
            'choices' => array(
                'standard' => __('Standard', 'municipio'),
                'article' => __('Article', 'municipio'),
            ),
            'default_value' => __('standard', 'municipio'),
            'return_format' => '',
            'multiple' => 0,
            'allow_null' => 0,
            'ui' => 1,
            'ajax' => 0,
            'placeholder' => '',
            'allow_custom' => 0,
            'search_placeholder' => '',
        ),
        2 => array(
            'key' => 'field_6405fea65cc8f',
            'label' => __('Background image', 'municipio'),
            'name' => 'backgroundImage',
            'type' => 'image',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'aria-label' => '',
            'uploader' => '',
            'acfe_thumbnail' => 0,
            'return_format' => 'id',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
            'preview_size' => 'medium',
            'library' => 'all',
        ),
        3 => array(
            'key' => 'field_64831fa89c119',
            'label' => __('Background color type', 'municipio'),
            'name' => 'background_color_type',
            'type' => 'radio',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'default' => __('Default', 'municipio'),
                'gradient' => __('Gradient', 'municipio'),
            ),
            'default_value' => __('default', 'municipio'),
            'return_format' => 'value',
            'allow_null' => 0,
            'other_choice' => 0,
            'save_other_choice' => 0,
            'layout' => 'vertical',
        ),
        4 => array(
            'key' => 'field_63cfdc219a6d3',
            'label' => __('Background color', 'municipio'),
            'name' => 'color',
            'type' => 'color_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
                0 => array(
                    0 => array(
                        'field' => 'field_64831fa89c119',
                        'operator' => '==',
                        'value' => 'default',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'enable_opacity' => 1,
            'return_format' => 'string',
        ),
        5 => array(
            'key' => 'field_6492ca98d635f',
            'label' => __('Gradient settings', 'municipio'),
            'name' => 'background_gradient_type',
            'type' => 'radio',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'basic' => __('Basic', 'municipio'),
                'advanced' => __('Advanced', 'municipio'),
            ),
            'default_value' => __('basic', 'municipio'),
            'return_format' => 'value',
            'allow_null' => 0,
            'other_choice' => 0,
            'layout' => 'vertical',
            'save_other_choice' => 0,
        ),
        6 => array(
            'key' => 'field_64832f14f941f',
            'label' => __('Gradient angle', 'municipio'),
            'name' => 'background_gradient_angle',
            'type' => 'range',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
                0 => array(
                    0 => array(
                        'field' => 'field_64831fa89c119',
                        'operator' => '==',
                        'value' => 'gradient',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 0,
            'min' => '',
            'max' => '',
            'step' => '',
            'prepend' => '',
            'append' => '',
        ),
        7 => array(
            'key' => 'field_648329b62db2e',
            'label' => __('Gradient background color', 'municipio'),
            'name' => 'background_gradient',
            'type' => 'repeater',
            'instructions' => __('The color with the lowest stop will always be shown first.', 'municipio'),
            'required' => 0,
            'conditional_logic' => array(
                0 => array(
                    0 => array(
                        'field' => 'field_64831fa89c119',
                        'operator' => '==',
                        'value' => 'gradient',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'acfe_repeater_stylised_button' => 0,
            'layout' => 'table',
            'pagination' => 0,
            'min' => 0,
            'max' => 0,
            'collapsed' => '',
            'button_label' => __('Add Row', 'municipio'),
            'rows_per_page' => 20,
            'sub_fields' => array(
                0 => array(
                    'key' => 'field_64832a1b2db2f',
                    'label' => __('Color', 'municipio'),
                    'name' => 'color',
                    'type' => 'color_picker',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'enable_opacity' => 1,
                    'return_format' => 'string',
                    'parent_repeater' => 'field_648329b62db2e',
                ),
                1 => array(
                    'key' => 'field_64832a342db30',
                    'label' => __('Stop', 'municipio'),
                    'name' => 'stop',
                    'type' => 'range',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        0 => array(
                            0 => array(
                                'field' => 'field_6492ca98d635f',
                                'operator' => '==',
                                'value' => 'advanced',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 0,
                    'min' => 0,
                    'max' => 100,
                    'step' => '',
                    'prepend' => '',
                    'append' => '',
                    'parent_repeater' => 'field_648329b62db2e',
                ),
            ),
        ),
        8 => array(
            'key' => 'field_644b77128c900',
            'label' => __('Text color', 'municipio'),
            'name' => 'text_color',
            'type' => 'color_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'aria-label' => '',
            'default_value' => '',
            'enable_opacity' => 0,
            'return_format' => 'string',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/container',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'left',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
    'acfe_display_title' => '',
    'acfe_autosync' => '',
    'acfe_form' => 0,
    'acfe_meta' => '',
    'acfe_note' => '',
));
}