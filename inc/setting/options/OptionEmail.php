<?php

namespace Puock\Theme\setting\options;

class OptionEmail extends BaseOptionItem{

    function get_fields(): array
    {
        return [
            'key' => 'email',
            'label' => __('SMTP 伺服器', PUOCK),
            'icon'=>'dashicons-email-alt',
            'fields' => [
                [
                    'id' => 'smtp_open',
                    'label' => __('開啟 SMTP', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                    'tips'=>__('開啟會覆蓋 WordPress 預設配置', PUOCK),
                ],
                [
                    'id' => 'smtp_ssl',
                    'label' => __('SMTP 加密', PUOCK),
                    'type' => 'switch',
                    'sdt' => 'false',
                    'showRefId' => 'smtp_open',
                ],
                [
                    'id' => 'smtp_form',
                    'label' => __('發件人 E-mail', PUOCK),
                    'sdt' => '',
                    'showRefId' => 'smtp_open',
                ],
                [
                    'id' => 'smtp_host',
                    'label' => __('SMTP 伺服器', PUOCK),
                    'sdt' => '',
                    'showRefId' => 'smtp_open',
                    'tips'=>'如 163 E-mail 的為：smtp.163.com'
                ],
                [
                    'id' => 'smtp_port',
                    'label' => __('SMTP 埠', PUOCK),
                    'sdt' => '',
                    'showRefId' => 'smtp_open',
                ],
                [
                    'id' => 'smtp_u',
                    'label' => __('SMTP 帳戶', PUOCK),
                    'sdt' => '',
                    'showRefId' => 'smtp_open',
                ],
                [
                    'id' => 'smtp_p',
                    'label' => __('SMTP 密碼', PUOCK),
                    'sdt' => '',
                    'showRefId' => 'smtp_open',
                    'tips'=>__('一般非 E-mail 帳號直接密碼，而是對應的平臺的 POP3/SMTP 授權碼', PUOCK),
                ],
            ],
        ];
    }
}
