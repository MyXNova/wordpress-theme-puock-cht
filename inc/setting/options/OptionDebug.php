<?php

namespace Puock\Theme\setting\options;

class OptionDebug extends BaseOptionItem{

    function get_fields(): array
    {
        return [
            'key' => 'debug',
            'label' =>  __('除錯與開發' , PUOCK),
            'icon'=>'dashicons-code-standards',
            'fields' => [
                [
                    'id' => 'debug_sql_count',
                    'label' => __('顯示SQL查詢統計', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                    'tips'=>__('此數據會顯示在<code>console</code>，需<code>F12</code>打開控制臺檢視', PUOCK),
                ],
                [
                    'id' => 'debug_sql_detail',
                    'label' => __('顯示SQL查詢詳情', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                    'tips'=>__("此數據會顯示在<code>console</code>，需<code>F12</code>打開控制臺檢視，需要在<code>wp-config.php</code>中加入<code>define('SAVEQUERIES', true);</code>", PUOCK)
                ],
            ],
        ];
    }
}
