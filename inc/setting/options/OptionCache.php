<?php

namespace Puock\Theme\setting\options;

class OptionCache extends BaseOptionItem{

    function get_fields(): array
    {
        return [
            'key' => 'cache',
            'label' => __('快取與效能', PUOCK),
            'icon'=>'dashicons-superhero',
            'fields' => [
                [
                    'id' => 'cache_expire_second',
                    'label' => __('快取過期秒數', PUOCK),
                    'type' => 'number',
                    'sdt' => 0,
                    'tips'=>__('0為不過期', PUOCK),
                ],
            ],
        ];
    }
}
