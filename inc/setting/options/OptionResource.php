<?php

namespace Puock\Theme\setting\options;

class OptionResource extends BaseOptionItem{

    function get_fields(): array
    {
        return [
            'key' => 'resource',
            'label' => __('資源與更新', PUOCK),
            'icon'=>'dashicons-cloud-saved',
            'fields' => [
                [
                    'id' => 'static_load_origin',
                    'label' => __('主題靜態資源載入源', PUOCK),
                    'type' => 'radio',
                    'sdt' => 'self',
                    'options' => [
                        [
                            'value' => 'self',
                            'label' => __('本機', PUOCK),
                        ],
                        [
                            'value' => 'jsdelivr',
                            'label' => 'JSDelivrCDN',
                        ],
                        [
                            'value' => 'jsdelivr-fastly',
                            'label' => 'JSDelivrFastly',
                        ],
                        [
                            'value' => 'jsdelivr-testingcf',
                            'label' => 'JSDelivrTestingcf',
                        ],
                        [
                            'value' => 'jsdelivr-gcore',
                            'label' => 'JSDelivrGcore',
                        ],
                        [
                            'value' => 'custom',
                            'label' => __('自定義（在下方一欄中填入）', PUOCK),
                        ],
                    ],
                ],
                [
                    'id' => 'custom_static_load_origin',
                    'label' => __('自定義靜態資源載入URI', PUOCK),
                    'sdt' => '',
                    'tips'=>__('需填寫完整地址，如<code>https://example.com/puock</code>，路徑需要指向到可以瀏覽主題根目錄為準', PUOCK)
                ],
                [
                    'id' => 'update_server',
                    'label' => __('主題線上更新源', PUOCK),
                    'type' => 'radio',
                    'sdt' => 'worker',
                    'options' => [
                        [
                            'value' => 'worker',
                            'label' => __('官方代理', PUOCK),
                        ],
                        [
                            'value' => 'github',
                            'label' => 'Github',
                        ],
                        [
                            'value' => 'fastgit',
                            'label' => 'fastgit',
                        ]
                    ],
                ],
                [
                    'id' => 'update_server_check_period',
                    'label' => __('主題更新檢測頻率', PUOCK),
                    'type' => 'number',
                    'sdt' => 6,
                    'tips'=>__('單位為小時', PUOCK),
                ],
            ],
        ];
    }
}
