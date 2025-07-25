<?php

namespace Puock\Theme\setting\options;

class OptionAuth extends BaseOptionItem
{

    function get_fields(): array
    {
        return [
            'key' => 'auth',
            'label' => __('登入與授權', PUOCK),
            'icon' => 'czs-qq',
            'fields' => [
                [
                    'id' => '-',
                    'label' => __('快捷登入', PUOCK),
                    'type' => 'panel',
                    'open' => true,
                    'children' => [
                        [
                            'id' => 'open_quick_login',
                            'label' => __('開啟快捷登入', PUOCK),
                            'type' => 'switch',
                            'sdt' => false,
                        ],
                        [
                            'id' => 'only_quick_oauth',
                            'label' => __('僅允許第三方登入', PUOCK),
                            'type' => 'switch',
                            'sdt' => false,
                        ],
                        [
                            'id' => 'quick_login_try_max_open',
                            'label' => __('啟用登入最大嘗試次數限制', PUOCK),
                            'tips' => __('超過此次數後，對應的 IP 將會被禁止登入', PUOCK),
                            'type' => 'switch',
                            'sdt' => false,
                        ],
                        [
                            'id' => 'quick_login_try_max_num',
                            'label' => __('登入最大嘗試次數', PUOCK),
                            'type' => 'number',
                            'sdt' => 3,
                        ],
                        [
                            'id' => 'quick_login_try_max_ban_time',
                            'label' => __('登入嘗試次數達到後禁止時間（分）', PUOCK),
                            'type' => 'number',
                            'sdt' => 10,
                        ],
                        [
                            'id' => 'quick_login_forget_password',
                            'label' => __('啟用忘記密碼找回', PUOCK),
                            'type' => 'switch',
                            'sdt' => false,
                        ],
                    ]
                ],
                [
                    'id' => '-',
                    'type' => 'panel',
                    'label' => __('後臺登入保護', PUOCK),
                    'open' => pk_is_checked('login_protection'),
                    'children' => [
                        [
                            'id' => 'login_protection',
                            'label' => __('啟用後臺登入保護', PUOCK),
                            'type' => 'switch',
                            'sdt' => 'false',
                            'tips' => 'func:(function(args){
                            const link = `' . home_url() . '/wp-login.php?${args.data.lp_user}=${args.data.lp_pass}`
                            return `<div>啟用後則用 <a href="${link}" target="_blank">${link}</a> 的方式訪問後臺入口</div>`
                        })(args)'
                        ],
                        [
                            'id' => 'lp_user',
                            'label' => __('後臺登入保護參數', PUOCK),
                            'sdt' => 'admin',
                            'showRefId' => 'login_protection',
                        ],
                        [
                            'id' => 'lp_pass',
                            'label' => __('後臺登入保護密碼', PUOCK),
                            'sdt' => 'admin',
                            'showRefId' => 'login_protection',
                        ],
                    ]
                ],
                [
                    'id' => '-',
                    'label' => __('第三方登入回撥地址提示', PUOCK),
                    'type' => 'info',
                    'infoType' => 'info',
                    'tips' => '通用回撥地址（callback url）為：<code>' . home_url() . '/wp-admin/admin-ajax.php</code>'
                ],
                [
                    'id' => 'oauth_close_register',
                    'label' => __('關閉第三方登入直接註冊', PUOCK),
                    'type' => 'switch',
                    'tips' => __('開啟後，若使用者未繫結過帳戶進行第三方登入時則不會自動建立新的帳戶', PUOCK),
                    'std' => false
                ],
                [
                    'id' => '-',
                    'label' => 'QQ ' . __('登入配置', PUOCK),
                    'type' => 'panel',
                    'open' => pk_is_checked('oauth_qq'),
                    'tips' => '<a target="_blank" href="https://wiki.connect.qq.com/%E7%BD%91%E7%AB%99%E6%8E%A5%E5%85%A5%E6%B5%81%E7%A8%8B">' . __('申請步驟及說明', PUOCK) . '</a>',
                    'children' => [
                        [
                            'id' => 'oauth_qq',
                            'label' => 'QQ ' . __('登入', PUOCK),
                            'type' => 'switch',
                            'sdt' => 'false',
                        ],
                        [
                            'id' => 'oauth_qq_id',
                            'label' => __('QQ 互聯', PUOCK) . ' APP ID',
                            'sdt' => '',
                            'showRefId' => 'oauth_qq',
                        ],
                        [
                            'id' => 'oauth_qq_key',
                            'label' => __('QQ 互聯', PUOCK) . ' APP KEY',
                            'sdt' => '',
                            'showRefId' => 'oauth_qq',
                        ],
                    ]
                ],
                [
                    'id' => '-',
                    'label' => 'Github ' . __('登入配置', PUOCK),
                    'type' => 'panel',
                    'open' => pk_is_checked('oauth_github'),
                    'tips' => '<a target="_blank" href="https://www.ruanyifeng.com/blog/2019/04/github-oauth.html">' . __('申請步驟及說明', PUOCK) . '</a>',
                    'children' => [
                        [
                            'id' => 'oauth_github',
                            'label' => 'Github ' . __('登入', PUOCK),
                            'type' => 'switch',
                            'sdt' => 'false',
                        ],
                        [
                            'id' => 'oauth_github_id',
                            'label' => 'Github Client ID',
                            'sdt' => '',
                            'showRefId' => 'oauth_github',
                        ],
                        [
                            'id' => 'oauth_github_secret',
                            'label' => 'Github Client Secret',
                            'sdt' => '',
                            'showRefId' => 'oauth_github',
                        ],
                    ]
                ],
                [
                    'id' => '-',
                    'label' => __('微博', PUOCK).' ' . __('登入配置', PUOCK),
                    'type' => 'panel',
                    'open' => pk_is_checked('oauth_weibo'),
                    'tips' => '<a target="_blank" href="https://open.weibo.com/wiki/%E7%BD%91%E7%AB%99%E6%8E%A5%E5%85%A5%E4%BB%8B%E7%BB%8D">' . __('申請步驟及說明', PUOCK) . '</a>',
                    'children' => [
                        [
                            'id' => 'oauth_weibo',
                            'label' => __('微博', PUOCK) . ' ' . __('登入', PUOCK),
                            'type' => 'switch',
                            'sdt' => 'false',
                        ],
                        [
                            'id' => 'oauth_weibo_key',
                            'label' => __('微博', PUOCK) . ' App Key',
                            'sdt' => '',
                            'showRefId' => 'oauth_weibo',
                        ],
                        [
                            'id' => 'oauth_weibo_secret',
                            'label' => __('微博', PUOCK) . ' App Secret',
                            'sdt' => '',
                            'showRefId' => 'oauth_weibo',
                        ],
                    ]
                ],
                [
                    'id' => '-',
                    'label' => 'Gitee ' . __('登入配置', PUOCK),
                    'type' => 'panel',
                    'open' => pk_is_checked('oauth_gitee'),
                    'tips' => '<a target="_blank" href="https://gitee.com/api/v5/oauth_doc#/list-item-3">' . __('申請步驟及說明', PUOCK) . '</a>',
                    'children' => [
                        [
                            'id' => 'oauth_gitee',
                            'label' => 'Gitee ' . __('登入', PUOCK),
                            'type' => 'switch',
                            'sdt' => 'false',
                        ],
                        [
                            'id' => 'oauth_gitee_id',
                            'label' => 'Gitee Client ID',
                            'sdt' => '',
                            'showRefId' => 'oauth_gitee',
                        ],
                        [
                            'id' => 'oauth_gitee_secret',
                            'label' => 'Gitee Client Secret',
                            'sdt' => '',
                            'showRefId' => 'oauth_gitee',
                        ],
                    ]
                ],
                [
                    'id' => '-',
                    'label' => 'LinuxDO ' . __('登录配置', PUOCK),
                    'type' => 'panel',
                    'open' => pk_is_checked('oauth_linuxdo'),
                    'tips' => '<a target="_blank" href="https://connect.linux.do">' . __('申请步骤及说明', PUOCK) . '</a>',
                    'children' => [
                        [
                            'id' => '-',
                            'label' => __('第三方登录回调地址提示', PUOCK),
                            'type' => 'info',
                            'infoType' => 'info',
                            'tips' => '通用回调地址（callback url）为: <code>' . PUOCK_ABS_URI . '/inc/oauth/callback/linuxdo.php</code>'
                        ],
                        [
                            'id' => 'oauth_linuxdo',
                            'label' => 'LinuxDO ' . __('登录', PUOCK),
                            'type' => 'switch',
                            'sdt' => 'false',
                        ],
                        [
                            'id' => 'oauth_linuxdo_id',
                            'label' => 'LinuxDO Client ID',
                            'sdt' => '',
                            'showRefId' => 'oauth_linuxdo',
                        ],
                        [
                            'id' => 'oauth_linuxdo_secret',
                            'label' => 'LinuxDO Client Secret',
                            'sdt' => '',
                            'showRefId' => 'oauth_linuxdo',
                        ],
                    ]
                ],
            ],
        ];
    }
}
