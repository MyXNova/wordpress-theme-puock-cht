<?php

namespace Puock\Theme\setting\options;

class OptionCarousel extends BaseOptionItem
{

    public static function getCarouselIndexArgs($encode = true)
    {
        $args = [
            'navigation' => [
                'nextEl' => '.index-banner-swiper .swiper-button-next',
                'prevEl' => '.index-banner-swiper .swiper-button-prev',
            ],
            'pagination' => [
                'el' => '.index-banner-swiper .swiper-pagination',
                'clickable' => true,
                'dynamicBullets' => true,
            ],
        ];
        if (!empty(pk_get_option('index_carousel_switch_effect'))) {
            $args['effect'] = pk_get_option('index_carousel_switch_effect');
        }
        if (pk_is_checked('index_carousel_mousewheel')) {
            $args['mousewheel'] = ['invert' => true];
        }
        $speed = pk_get_option('index_carousel_autoplay_speed');
        if ($speed && $speed > 0) {
            $args['autoplay'] = ['delay' => $speed, 'disableOnInteraction' => false];
        }
        if (pk_is_checked('index_carousel_loop')) {
            $args['loop'] = true;
        }
        return $encode ? json_encode($args) : $args;
    }

    function get_fields(): array
    {
        return [
            'key' => 'carousel',
            'label' => __('幻燈與公告', PUOCK),
            'icon' => 'dashicons-format-gallery',
            'fields' => [
                [
                    'id' => '-',
                    'type' => 'panel',
                    'label' => __('首頁幻燈片', PUOCK),
                    'open' => pk_is_checked('index_carousel'),
                    'children' => [
                        [
                            'id' => '-',
                            'type' => 'info',
                            'tips' => __('說明：幻燈片尺寸建議統一為2:1的比例，例如800*400，另外所有的幻燈片尺寸必須完全一致，否則會出現高度不一的情況！', PUOCK),
                        ],
                        [
                            'id' => 'index_carousel',
                            'label' => __('啟用', PUOCK),
                            'type' => 'switch',
                            'sdt' => true,
                        ],
                        [
                            'id' => 'index_carousel_mousewheel',
                            'label' => __('滑鼠滾輪切換', PUOCK),
                            'type' => 'switch',
                            'sdt' => true,
                        ],
                        [
                            'id' => 'index_carousel_hide_title',
                            'label' => __('隱藏標題', PUOCK),
                            'type' => 'switch',
                            'sdt' => false,
                        ],
                        [
                            'id' => 'index_carousel_loop',
                            'label' => __('循環播放', PUOCK),
                            'type' => 'switch',
                            'sdt' => true,
                        ],
                        [
                            'id' => 'index_carousel_autoplay_speed',
                            'label' => __('自動播放速度（毫秒）', PUOCK),
                            'tips' => __('0為不自動播放', PUOCK),
                            'type' => 'number',
                            'sdt' => 3000,
                        ],
                        [
                            'id' => 'index_carousel_switch_effect',
                            'label' => __('切換效果', PUOCK),
                            'type' => 'select',
                            'sdt' => '',
                            'options' => [
                                ['label' => __('預設', PUOCK), 'value' => ''],
                                ['label' => __('淡入淡出', PUOCK), 'value' => 'fade'],
                                ['label' => __('立方體', PUOCK), 'value' => 'cube'],
                                ['label' => __('快速翻轉', PUOCK), 'value' => 'flip'],
                                ['label' => __('覆蓋流', PUOCK), 'value' => 'coverflow'],
                                ['label' => __('卡片', PUOCK), 'value' => 'cards']
                            ]
                        ],
                        [
                            'id' => 'index_carousel_list',
                            'label' => __('幻燈片列表', PUOCK),
                            'type' => 'dynamic-list',
                            'sdt' => [],
                            'draggable' => true,
                            'dynamicModel' => [
                                ['id' => 'title', 'label' => __('幻燈標題', PUOCK), 'std' => ''],
                                ['id' => 'img', 'label' => __('幻燈圖片', PUOCK), 'std' => '', 'type' => 'img', 'tips' => __('建議尺寸2:1，所有圖片大小必須一致', PUOCK)],
                                ['id' => 'link', 'label' => __('指向連結', PUOCK), 'std' => ''],
                                ['id' => 'blank', 'label' => __('新標籤打開', PUOCK), 'std' => false, 'type' => 'switch'],
                                ['id' => 'hide', 'label' => __('隱藏', PUOCK), 'type' => 'switch', 'sdt' => false, 'tips' => __('隱藏後將不會顯示', PUOCK)],
                            ],
                        ],
                    ]
                ],
                [
                    'id' => '-',
                    'type' => 'panel',
                    'label' => __('全域性公告', PUOCK),
                    'open' => pk_is_checked('global_notice'),
                    'children' => [
                        [
                            'id' => 'global_notice',
                            'label' => __('啟用', PUOCK),
                            'type' => 'switch',
                            'sdt' => false,
                        ],
                        [
                            'id' => 'global_notice_autoplay_speed',
                            'label' => __('自動播放速度（毫秒）', PUOCK),
                            'tips' => __('0為不自動播放', PUOCK),
                            'type' => 'number',
                            'sdt' => 3000,
                        ],
                        [
                            'id' => 'global_notice_list',
                            'label' => __('公告列表', PUOCK),
                            'type' => 'dynamic-list',
                            'sdt' => [],
                            'draggable' => true,
                            'dynamicModel' => [
                                ['id' => 'title', 'label' => __('公告標題(支援HTML)', PUOCK), 'type' => 'textarea', 'std' => ''],
                                ['id' => 'link', 'label' => __('指向連結(可空)', PUOCK), 'std' => ''],
                                ['id' => 'icon', 'label' => __('圖示class(可空)', PUOCK), 'std' => ''],
                                ['id' => 'hide', 'label' => __('隱藏', PUOCK), 'type' => 'switch', 'sdt' => false, 'tips' => __('隱藏後將不會顯示', PUOCK)],
                            ],
                        ],
                    ]
                ]
            ],
        ];
    }
}
