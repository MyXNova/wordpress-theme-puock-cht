<?php

namespace Puock\Theme\setting\options;

class OptionAi
{
    function get_fields(): array
    {
        return [
            'key' => 'ai',
            'label' => __('智慧AI助手', PUOCK),
            'icon' => 'czs-robot',
            'fields' => [
                [
                    'id' => 'ai_chat_enable',
                    'label' => __('啟用AI助手', PUOCK),
                    'type' => 'switch',
                    'tips' => __('啟用後去<a href="/wp-admin/post-new.php?post_type=page">建立頁面</a>選擇<code>AI助手</code>模板即可使用', PUOCK)
                ],
                [
                    'id' => 'ai_chat_platform',
                    'label' => __('API 提供商', PUOCK),
                    'type' => 'radio',
                    'sdt' => 'gptnb',
                    'options' => [
                        [
                            'value' => 'gptnb',
                            'label' => __('GPTNB', PUOCK),
                        ],
                        [
                            'value' => 'openai',
                            'label' => __('OpenAI', PUOCK),
                        ],
                        [
                            'value' => 'custom',
                            'label' => __('自定義', PUOCK),
                        ],
                    ],
                    'tips' => __('<a href="https://goapi.gptnb.ai" target="_blank"><code>GPTNB（第三方中轉）<i class="fa-solid fa-arrow-up-right-from-square"></i></code></a> | <a href="https://platform.openai.com" target="_blank"><code>OpenAI（官方）<i class="fa-solid fa-arrow-up-right-from-square"></i></code></a>（注意：第三方中轉由第三方服務商提供，本程式不承諾任何擔保，若有任何疑問請諮詢對應的網站客服）', PUOCK),
                ],
                [
                    'id' => 'ai_chat_key',
                    'label' => __('API KEY', PUOCK),
                    'type' => 'text',
                    'sdt' => pk_get_option('openai_api_key'),
                    'tips' => __('請在上方選擇的對應的服務商申請獲取API Key，然後在此填入', PUOCK),
                ],
                [
                    'id' => 'ai_chat_agent',
                    'label' => __('自定義 API 代理域', PUOCK),
                    'type' => 'text',
                    'sdt' => '',
                    'showRefId'=>'func:(function(args){return args.data.ai_chat_platform==="custom"})(args)',
                    'tips' => __('如果您要使用其他平臺請自行配置代理域名，例如您自己的反向代理等，其API規範必須符合OpenAI API', PUOCK),
                ],
                [
                    'id' => 'ai_chat_models',
                    'label' => __('對話模型', PUOCK),
                    'type' => 'dynamic-list',
                    'sdt' => [
                        ['name'=>'gpt-3.5-turbo','alias'=>'GPT-3.5-TURBO','enable'=>true],
                        ['name'=>'gpt-3.5-turbo-16k','alias'=>'GPT-3.5-TURBO-16K','enable'=>true],
                        ['name'=>'gpt-4','alias'=>'GPT-4'],
                        ['name'=>'gpt-4-32k','alias'=>'GPT-4-32K'],
                    ],
                    'draggable' => true,
                    'dynamicModel' => [
                        ['id' => 'name', 'label' => __('模型名稱', PUOCK), 'std' => '','tips' => __('用於傳遞給平臺的模型名稱', PUOCK)],
                        ['id' => 'alias', 'label' => __('模型別名', PUOCK), 'std' => '','tips' => __('用於展示給使用者的名稱', PUOCK)],
                        ['id' => 'max_tokens', 'label' => __('模型最大Tokens', PUOCK), 'std' => 0, 'tips' => __('為0則無限制', PUOCK), 'type'=>'number'],
                        ['id' => 'enable', 'label' => __('啟用', PUOCK), 'type' => 'switch'],
                    ],
                ],
                [
                    'id' => 'ai_chat_model_sys_prompt',
                    'label' => __('模型系統預設', PUOCK),
                    'type' => 'textarea',
                    'sdt' => pk_get_option('openai_model_sys_content'),
                    'tips' => __('模型系統預設，可讓AI主動進行一些違規話題的遮蔽，不懂勿輕易填充', PUOCK),
                ],
                [
                    'id' => 'ai_chat_stream',
                    'label' => __('使用Stream(實時輸出)模式', PUOCK),
                    'type' => 'switch',
                    'sdt' => pk_is_checked('openai_stream'),
                    'tips' => __('啟用後請關閉nginx的<code>gzip</code>模式', PUOCK),
                ],
                [
                    'id' => 'ai_chat_welcome',
                    'label' => __('預設歡迎對話', PUOCK),
                    'type' => 'textarea',
                    'sdt' => pk_get_option('openai_default_welcome_chat', '您好，歡迎使用智慧AI助理'),
                    'tips' => '支援HTML程式碼',
                ],
                [
                    'id' => 'ai_draw_dall_e',
                    'label' => __('AI繪畫支援', PUOCK),
                    'type' => 'switch',
                    'sdt' => pk_is_checked('openai_dall_e'),
                    'tips' => __('啟用後前端界面<code>勾選繪畫模式</code>即可繪畫', PUOCK),
                ],
                [
                    'id' => 'ai_draw_dall_e_model',
                    'label' => __('AI繪畫模型', PUOCK),
                    'type' => 'select',
                    'sdt' => pk_get_option('ai_draw_dall_e_model', 'dall-e-2'),
                    'options' => [
                        ['label' => 'DallE-2', 'value' => 'dall-e-2'],
                        ['label' => 'DallE-3', 'value' => 'dall-e-3'],
                    ],
                ],
                [
                    'id' => 'ai_draw_dall_e_size',
                    'label' => __('AI繪畫圖片大小', PUOCK),
                    'type' => 'select',
                    'sdt' => pk_get_option('openai_dall_e_size', '512x512'),
                    'options' => [
                        ['label' => '256x256', 'value' => '256x256'],
                        ['label' => '512x512', 'value' => '512x512'],
                        ['label' => '1024x1024', 'value' => '1024x1024'],
                        ['label' => '1792x1024（僅DallE-3支援）', 'value' => '1792x1024'],
                        ['label' => '1024x1792（僅DallE-3支援）', 'value' => '1024x1792'],
                    ],
                ],
                [
                    'id' => 'ai_guest_use',
                    'label' => __('允許遊客使用', PUOCK),
                    'type' => 'switch',
                    'sdt' => pk_is_checked('openai_guest_use'),
                    'tips' => __('是否在未登入狀態下也可以使用', PUOCK),
                ],
            ]
        ];
    }
}
