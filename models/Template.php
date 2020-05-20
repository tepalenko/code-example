<?php

namespace app\models;

use yii\db\ActiveRecord;

class Template extends ActiveRecord
{
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'templates';
    }

    /**
     * Convert template id to template name
     *
     * @return string the name of template.
     */
    public static function convertToString($template_id)
    {
        $templates = [
            'templateNewOne',
            'templateNewTwo',
            'templateNewThree',
            'templateFour',
            'templateFive',
            'templateSix',
            'templateSeven',
            'templateEight',
            'templateNine',
            'templateTen',
            'templateEleven'
        ];
        
        return  $templates[$template_id-1];
    }

    /**
     * Get template params by template_id
     *
     * @param number $template_id
     * @return array
     */
    public static function getFormParams($template_id)
    {
        $template_name = self::convertToString($template_id);

        $templates = [
            'templateNewOne' => [
                'template', // param for preview feature
                'title',
                'type',
                'description',
                'youtube_link',
                'product_tour_link_show',
                'product_tour_link_text',
                'product_tour_id',
                'next_modal_link_show',
                'next_modal_link_text',
                'next_modal_id',
            ],
            'templateNewTwo' => [
                'template',// param for preview feature
                'title',
                'type',
                'imageFile',
                'file',
                'product_tour_link_show',
                'product_tour_link_text',
                'product_tour_id'
            ],
            'templateNewThree' => [
                'template',// param for preview feature
                'title',
                'type',
                'imageFile',
                'file',
                'product_tour_link_show',
                'product_tour_link_text',
                'product_tour_id'
            ],
            'templateFour' => [
                'template',// param for preview feature
                'title',
                'description',
                'type',
                'imageFile',
                'file',
                'button_text',
                'button_modal_id',
                'button_product_tour_id',
                'button_action_next',
                'related_tutorial_1_text',
                'related_tutorial_1_modal_id',
                'related_tutorial_1_product_tour_id',
                'related_tutorial_2_text',
                'related_tutorial_2_modal_id',
                'related_tutorial_2_product_tour_id',
                'related_tutorial_3_text',
                'related_tutorial_3_modal_id',
                'related_tutorial_3_product_tour_id',
                'related_tutorial_4_text',
                'related_tutorial_4_modal_id',
                'related_tutorial_4_product_tour_id',
            ],
            'templateFive' => [
                'template',// param for preview feature
                'title',
                'youtube_link',
                'type',
                'product_tour_link_show',
                'product_tour_link_text',
                'product_tour_id',
                'next_modal_link_show',
                'next_modal_link_text',
                'next_modal_id'
            ],
            'templateSix' => [
                'template',// param for preview feature
                'title',
                'content',
                'type',
                'product_tour_link_show',
                'product_tour_link_text',
                'product_tour_id'
            ],
            'templateSeven' => [
                'template',// param for preview feature
                'title',
                'description',
                'type',
                'imageFile',
                'file',
                'button_text'
            ],
            'templateEight' => [
                'template',// param for preview feature
                'title',
                'description',
                'imageFile',
                'file',
                'type',
                'product_tour_link_show',
                'product_tour_link_text',
                'product_tour_id'
            ],
            'templateNine' => [
                'template', // param for preview feature
                'title',
                'type',
                'imageFile',
                'file',
                'product_tour_link_show',
                'product_tour_link_text',
                'product_tour_id'
            ],
            'templateTen' => [
                'template', // param for preview feature
                'title',
                'description',
                'type',
                'imageFile',
                'file',
                'button_text',
                'button_modal_id',
                'button_product_tour_id',
            ],
            'templateEleven' => [
                'template', // param for preview feature
                'type',
                'title',
                'description',
                'imageFile',
                'file'
            ],

        ];
        return  $templates[$template_name];
    }
}
