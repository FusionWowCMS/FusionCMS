<?php

# Import required classes
use MX\MX_Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;

# Make sure we're in CI
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package    Install
 * @subpackage controllers
 * @since      1.0.0
 * @version    1.0.0
 * @author     Ehsan Zare <darksider.legend@gmail.com>
 * @link       https://code-path.com
 * @copyright  (c) 2024 Code-path web developing team
 */

class Upgrade extends MX_Controller
{
    # Statements
    private array $statements;

    public function __construct()
    {
        parent::__construct();

        # Make sure CMS is installed
        if(!file_exists(WRITEPATH . 'install' . DIRECTORY_SEPARATOR . '.lock'))
            die($this->load->view('errors/html/error_general', ['heading' => 'Upgrade failed!', 'message' => 'Please install the FusionCMS before attempting to upgrade!', 'code' => 403], true));

        # user: Is online
        if(!$this->user->isOnline())
            redirect(base_url('login'));

        # User: Is owner
        if(!$this->user->isOwner())
            show_404('upgrade', false);

        # Load: Helpers
        $this->load->helper('url');

        # Statements: Fill
        $this->statements = [
            # FusionCMS
            'fcms8' => [
                'info' => [
                    'name'    => 'FusionCMS 8.x',
                    'version' => '8.x'
                ],

                'queries' => [
                    '001' => [
                        'select' => [
                            'table'   => 'account_data',
                            'columns' => ['id', 'vp', 'dp', 'avatar', 'location', 'nickname', 'language', 'total_votes']
                        ],

                        'insert' => [
                            'table'   => 'account_data',
                            'columns' => ['id', 'vp', 'dp', 'avatar', 'location', 'nickname', 'language', 'total_votes']
                        ]
                    ],

                    '002' => [
                        'select' => [
                            'table'   => 'articles',
                            'columns' => ['id', 'timestamp', 'author_id', 'comments', 'type', 'type_content', 'headline', 'content']
                        ],

                        'insert' => [
                            'table'   => 'articles',
                            'columns' => ['id', 'timestamp', 'author_id', 'comments', 'type', 'type_content', 'headline', 'content']
                        ]
                    ],

                    '003' => [
                        'select' => [
                            'table'   => 'comments',
                            'columns' => ['id', 'article_id', 'author_id', 'timestamp', 'content', 'is_gm']
                        ],

                        'insert' => [
                            'table'   => 'comments',
                            'columns' => ['id', 'article_id', 'author_id', 'timestamp', 'content', 'is_gm']
                        ]
                    ],

                    '004' => [
                        'select' => [
                            'table'   => 'changelog_type',
                            'columns' => ['id', 'typeName']
                        ],

                        'insert' => [
                            'table'   => 'changelog_type',
                            'columns' => ['id', 'typeName']
                        ]
                    ],

                    '005' => [
                        'select' => [
                            'table'   => 'changelog',
                            'columns' => ['change_id', 'changelog', 'author', 'type', 'time']
                        ],

                        'insert' => [
                            'table'   => 'changelog',
                            'columns' => ['change_id', 'changelog', 'author', 'type', 'time']
                        ]
                    ],

                    '006' => [
                        'select' => [
                            'table'   => 'email_log',
                            'columns' => ['id', 'uid', 'email', 'subject', 'message', 'timestamp']
                        ],

                        'insert' => [
                            'table'   => 'email_log',
                            'columns' => ['id', 'uid', 'email', 'subject', 'message', 'timestamp']
                        ]
                    ],

                    '007' => [
                        'select' => [
                            'table'   => 'gm_log',
                            'columns' => ['id', 'action', 'gm_id', 'affected', 'ip', 'type', 'realm', 'time']
                        ],

                        'insert' => [
                            'table'   => 'gm_log',
                            'columns' => ['id', 'action', 'gm_id', 'affected', 'ip', 'type', 'realm', 'time']
                        ]
                    ],

                    '008' => [
                        'select' => [
                            'table'   => 'logs',
                            'columns' => ['id', 'module', 'user_id', 'type', 'event', 'message', 'status', 'custom', 'ip', 'time']
                        ],

                        'insert' => [
                            'table'   => 'logs',
                            'columns' => ['id', 'module', 'user_id', 'type', 'event', 'message', 'status', 'custom', 'ip', 'time']
                        ]
                    ],

                    '009' => [
                        'select' => [
                            'table'   => 'monthly_income',
                            'columns' => ['month', 'amount']
                        ],

                        'insert' => [
                            'table'   => 'monthly_income',
                            'columns' => ['month', 'amount']
                        ]
                    ],

                    '010' => [
                        'select' => [
                            'table'   => 'monthly_votes',
                            'columns' => ['month', 'amount']
                        ],

                        'insert' => [
                            'table'   => 'monthly_votes',
                            'columns' => ['month', 'amount']
                        ]
                    ],

                    '011' => [
                        'select' => [
                            'table'   => 'order_log',
                            'columns' => ['id', 'completed', 'user_id', 'vp_cost', 'dp_cost', 'cart', 'timestamp']
                        ],

                        'insert' => [
                            'table'   => 'order_log',
                            'columns' => ['id', 'completed', 'user_id', 'vp_cost', 'dp_cost', 'cart', 'timestamp']
                        ]
                    ],

                    '012' => [
                        'select' => [
                            'table'   => 'pages',
                            'columns' => ['id', 'identifier', 'name', 'content', 'permission', 'rank_needed']
                        ],

                        'insert' => [
                            'table'   => 'pages',
                            'columns' => ['id', 'identifier', 'name', 'content', 'permission', 'rank_needed']
                        ]
                    ],

                    '013' => [
                        'select' => [
                            'table'   => 'paypal_donate',
                            'columns' => ['id', 'price', 'tax', 'points']
                        ],

                        'insert' => [
                            'table'   => 'paypal_donate',
                            'columns' => ['id', 'price', 'tax', 'points']
                        ]
                    ],

                    '014' => [
                        'select' => [
                            'table'   => 'paypal_logs',
                            'columns' => ['id', 'user_id', 'payment_id', 'hash', 'total', 'points', 'create_time', 'currency', 'error', 'status', 'invoice_number', 'payer_email', 'token', 'transactions_code']
                        ],

                        'insert' => [
                            'table'   => 'paypal_logs',
                            'columns' => ['id', 'user_id', 'payment_id', 'hash', 'total', 'points', 'create_time', 'currency', 'error', 'status', 'invoice_number', 'payer_email', 'token', 'transactions_code']
                        ]
                    ],

                    '015' => [
                        'select' => [
                            'table'   => 'sideboxes',
                            'columns' => ['id', 'type', 'displayName', 'rank_needed', 'order', 'location', 'permission']
                        ],

                        'insert' => [
                            'table'   => 'sideboxes',
                            'columns' => ['id', 'type', 'displayName', 'rank_needed', 'order', 'location', 'permission']
                        ]
                    ],

                    '016' => [
                        'select' => [
                            'table'   => 'sideboxes_custom',
                            'columns' => ['sidebox_id', 'content']
                        ],

                        'insert' => [
                            'table'   => 'sideboxes_custom',
                            'columns' => ['sidebox_id', 'content']
                        ]
                    ],

                    '017' => [
                        'select' => [
                            'table'   => 'store_groups',
                            'columns' => ['id', 'title', 'orderNumber']
                        ],

                        'insert' => [
                            'table'   => 'store_groups',
                            'columns' => ['id', 'title', 'orderNumber']
                        ]
                    ],

                    '018' => [
                        'select' => [
                            'table'   => 'store_items',
                            'columns' => ['id', 'itemid', 'itemcount', 'name', 'quality', 'vp_price', 'dp_price', 'realm', 'description', 'icon', 'group', 'query', 'query_database', 'query_need_character', 'command', 'command_need_character', 'require_character_offline', 'tooltip']
                        ],

                        'insert' => [
                            'table'   => 'store_items',
                            'columns' => ['id', 'itemid', 'itemcount', 'name', 'quality', 'vp_price', 'dp_price', 'realm', 'description', 'icon', 'group', 'query', 'query_database', 'query_need_character', 'command', 'command_need_character', 'require_character_offline', 'tooltip']
                        ]
                    ],

                    '019' => [
                        'select' => [
                            'table'   => 'teleport_locations',
                            'columns' => ['id', 'name', 'description', 'x', 'y', 'z', 'orientation', 'mapId', 'vpCost', 'dpCost', 'goldCost', 'realm', 'required_faction']
                        ],

                        'insert' => [
                            'table'   => 'teleport_locations',
                            'columns' => ['id', 'name', 'description', 'x', 'y', 'z', 'orientation', 'mapId', 'vpCost', 'dpCost', 'goldCost', 'realm', 'required_faction']
                        ]
                    ],

                    '020' => [
                        'select' => [
                            'table'   => 'vote_sites',
                            'columns' => ['id', 'vote_sitename', 'vote_url', 'vote_image', 'hour_interval', 'points_per_vote', 'callback_enabled']
                        ],

                        'insert' => [
                            'table'   => 'vote_sites',
                            'columns' => ['id', 'vote_sitename', 'vote_url', 'vote_image', 'hour_interval', 'points_per_vote', 'callback_enabled']
                        ]
                    ],

                    '021' => [
                        'select' => [
                            'table'   => 'vote_log',
                            'columns' => ['id', 'vote_site_id', 'user_id', 'ip', 'time']
                        ],

                        'insert' => [
                            'table'   => 'vote_log',
                            'columns' => ['id', 'vote_site_id', 'user_id', 'ip', 'time']
                        ]
                    ],

                    '022' => [
                        'select' => [
                            'table'   => 'menu',
                            'columns' => ['id', 'name', 'link', 'type', 'rank', 'specific_rank', 'order', 'permission', 'side', 'dropdown', 'parent_id']
                        ],

                        'insert' => [
                            'table'   => 'menu',
                            'columns' => ['id', 'name', 'link', 'type', 'rank', 'specific_rank', 'order', 'permission', 'side', 'dropdown', 'parent_id']
                        ]
                    ]
                ]
            ],

            # FusionCMS 6
            'fcms6' => [
                'info' => [
                    'name'    => 'FusionCMS 6.x',
                    'version' => '6.x'
                ],

                'queries' => [
                    '001' => [
                        'select' => [
                            'table'   => 'account_data',
                            'columns' => ['id', 'vp', 'dp', 'location', 'nickname']
                        ],

                        'insert' => [
                            'table'   => 'account_data',
                            'columns' => ['id', 'vp', 'dp', 'location', 'nickname']
                        ]
                    ],

                    '002' => [
                        'select' => [
                            'table'   => 'articles',
                            'columns' => ['id', 'timestamp', 'author_id', 'comments', 'headline', 'content']
                        ],

                        'insert' => [
                            'table'   => 'articles',
                            'columns' => ['id', 'timestamp', 'author_id', 'comments', 'headline', 'content']
                        ]
                    ],

                    '003' => [
                        'select' => [
                            'table'   => 'comments',
                            'columns' => ['id', 'article_id', 'author_id', 'timestamp', 'content']
                        ],

                        'insert' => [
                            'table'   => 'comments',
                            'columns' => ['id', 'article_id', 'author_id', 'timestamp', 'content']
                        ]
                    ],

                    '004' => [
                        'select' => [
                            'table'   => 'changelog_type',
                            'columns' => ['id', 'typeName']
                        ],

                        'insert' => [
                            'table'   => 'changelog_type',
                            'columns' => ['id', 'typeName']
                        ]
                    ],

                    '005' => [
                        'select' => [
                            'table'   => 'changelog',
                            'columns' => ['change_id', 'changelog', 'author', 'type', 'time']
                        ],

                        'insert' => [
                            'table'   => 'changelog',
                            'columns' => ['change_id', 'changelog', 'author', 'type', 'time']
                        ]
                    ],

                    '009' => [
                        'select' => [
                            'table'   => 'monthly_income',
                            'columns' => ['month', 'amount']
                        ],

                        'insert' => [
                            'table'   => 'monthly_income',
                            'columns' => ['month', 'amount']
                        ]
                    ],

                    '010' => [
                        'select' => [
                            'table'   => 'monthly_votes',
                            'columns' => ['month', 'amount']
                        ],

                        'insert' => [
                            'table'   => 'monthly_votes',
                            'columns' => ['month', 'amount']
                        ]
                    ],

                    '011' => [
                        'select' => [
                            'table'   => 'order_log',
                            'columns' => ['id', 'completed', 'user_id', 'vp_cost', 'dp_cost', 'cart', 'timestamp']
                        ],

                        'insert' => [
                            'table'   => 'order_log',
                            'columns' => ['id', 'completed', 'user_id', 'vp_cost', 'dp_cost', 'cart', 'timestamp']
                        ]
                    ],

                    '012' => [
                        'select' => [
                            'table'   => 'pages',
                            'columns' => ['id', 'identifier', 'name', 'content', 'rank_needed']
                        ],

                        'insert' => [
                            'table'   => 'pages',
                            'columns' => ['id', 'identifier', 'name', 'content', 'rank_needed']
                        ]
                    ],

                    '014' => [
                        'select' => [
                            'table'   => 'paypal_logs',
                            'columns' => ['id', 'user_id', 'payment_status', 'payment_currency', 'payment_amount', 'txn_id', 'payer_email', 'error', 'timestamp']
                        ],

                        'insert' => [
                            'table'   => 'paypal_logs',
                            'columns' => ['id', 'user_id', 'status', 'currency', 'total', 'transactions_code', 'payer_email', 'error', 'create_time']
                        ]
                    ],

                    '015' => [
                        'select' => [
                            'table'   => 'sideboxes',
                            'columns' => ['id', 'type', 'displayName', 'rank_needed', 'order']
                        ],

                        'insert' => [
                            'table'   => 'sideboxes',
                            'columns' => ['id', 'type', 'displayName', 'rank_needed', 'order']
                        ]
                    ],

                    '016' => [
                        'select' => [
                            'table'   => 'sideboxes_custom',
                            'columns' => ['sidebox_id', 'content']
                        ],

                        'insert' => [
                            'table'   => 'sideboxes_custom',
                            'columns' => ['sidebox_id', 'content']
                        ]
                    ],

                    '017' => [
                        'select' => [
                            'table'   => 'store_groups',
                            'columns' => ['id', 'title']
                        ],

                        'insert' => [
                            'table'   => 'store_groups',
                            'columns' => ['id', 'title']
                        ]
                    ],

                    '018' => [
                        'select' => [
                            'table'   => 'store_items',
                            'columns' => ['id', 'itemid', 'name', 'quality', 'vp_price', 'dp_price', 'realm', 'description', 'icon', 'group', 'query', 'query_database', 'query_need_character', 'tooltip']
                        ],

                        'insert' => [
                            'table'   => 'store_items',
                            'columns' => ['id', 'itemid', 'name', 'quality', 'vp_price', 'dp_price', 'realm', 'description', 'icon', 'group', 'query', 'query_database', 'query_need_character', 'tooltip']
                        ]
                    ],

                    '019' => [
                        'select' => [
                            'table'   => 'teleport_locations',
                            'columns' => ['id', 'name', 'description', 'x', 'y', 'z', 'orientation', 'mapId', 'vpCost', 'dpCost', 'goldCost', 'realm', 'required_faction']
                        ],

                        'insert' => [
                            'table'   => 'teleport_locations',
                            'columns' => ['id', 'name', 'description', 'x', 'y', 'z', 'orientation', 'mapId', 'vpCost', 'dpCost', 'goldCost', 'realm', 'required_faction']
                        ]
                    ],

                    '020' => [
                        'select' => [
                            'table'   => 'vote_sites',
                            'columns' => ['id', 'vote_sitename', 'vote_url', 'vote_image', 'hour_interval', 'points_per_vote', 'api_enabled']
                        ],

                        'insert' => [
                            'table'   => 'vote_sites',
                            'columns' => ['id', 'vote_sitename', 'vote_url', 'vote_image', 'hour_interval', 'points_per_vote', 'callback_enabled']
                        ]
                    ],

                    '021' => [
                        'select' => [
                            'table'   => 'vote_log',
                            'columns' => ['id', 'vote_site_id', 'user_id', 'ip', 'time']
                        ],

                        'insert' => [
                            'table'   => 'vote_log',
                            'columns' => ['id', 'vote_site_id', 'user_id', 'ip', 'time']
                        ]
                    ]
                ]
            ],

            # FusionGEN
            'fgen' => [
                'info' => [
                    'name'    => 'FusionGEN',
                    'version' => '1.x'
                ],

                'queries' => [
                    '001' => [
                        'select' => [
                            'table'   => 'account_data',
                            'columns' => ['id', 'vp', 'dp', 'avatar', 'location', 'nickname', 'language', 'total_votes']
                        ],

                        'insert' => [
                            'table'   => 'account_data',
                            'columns' => ['id', 'vp', 'dp', 'avatar', 'location', 'nickname', 'language', 'total_votes']
                        ]
                    ],

                    '002' => [
                        'select' => [
                            'table'   => 'articles',
                            'columns' => ['id', 'timestamp', 'author_id', 'comments', 'type', 'type_content', 'headline_en', 'content_en']
                        ],

                        'insert' => [
                            'table'   => 'articles',
                            'columns' => ['id', 'timestamp', 'author_id', 'comments', 'type', 'type_content', 'headline', 'content']
                        ]
                    ],

                    '003' => [
                        'select' => [
                            'table'   => 'comments',
                            'columns' => ['id', 'article_id', 'author_id', 'timestamp', 'content', 'is_gm']
                        ],

                        'insert' => [
                            'table'   => 'comments',
                            'columns' => ['id', 'article_id', 'author_id', 'timestamp', 'content', 'is_gm']
                        ]
                    ],

                    '004' => [
                        'select' => [
                            'table'   => 'changelog_type',
                            'columns' => ['id', 'typeName']
                        ],

                        'insert' => [
                            'table'   => 'changelog_type',
                            'columns' => ['id', 'typeName']
                        ]
                    ],

                    '005' => [
                        'select' => [
                            'table'   => 'changelog',
                            'columns' => ['change_id', 'changelog', 'author', 'type', 'time']
                        ],

                        'insert' => [
                            'table'   => 'changelog',
                            'columns' => ['change_id', 'changelog', 'author', 'type', 'time']
                        ]
                    ],

                    '006' => [
                        'select' => [
                            'table'   => 'email_log',
                            'columns' => ['id', 'uid', 'email', 'subject', 'message', 'timestamp']
                        ],

                        'insert' => [
                            'table'   => 'email_log',
                            'columns' => ['id', 'uid', 'email', 'subject', 'message', 'timestamp']
                        ]
                    ],

                    '007' => [
                        'select' => [
                            'table'   => 'mod_logs',
                            'columns' => ['id', 'action', 'mod', 'affected', 'ip', 'realm', 'time']
                        ],

                        'insert' => [
                            'table'   => 'gm_log',
                            'columns' => ['id', 'action', 'gm_id', 'affected', 'ip', 'realm', 'time']
                        ]
                    ],

                    '008' => [
                        'select' => [
                            'table'   => 'logs',
                            'columns' => ['id', 'module', 'user_id', 'type', 'event', 'message', 'status', 'custom', 'ip', 'time']
                        ],

                        'insert' => [
                            'table'   => 'logs',
                            'columns' => ['id', 'module', 'user_id', 'type', 'event', 'message', 'status', 'custom', 'ip', 'time']
                        ]
                    ],

                    '009' => [
                        'select' => [
                            'table'   => 'monthly_income',
                            'columns' => ['month', 'amount']
                        ],

                        'insert' => [
                            'table'   => 'monthly_income',
                            'columns' => ['month', 'amount']
                        ]
                    ],

                    '010' => [
                        'select' => [
                            'table'   => 'monthly_votes',
                            'columns' => ['month', 'amount']
                        ],

                        'insert' => [
                            'table'   => 'monthly_votes',
                            'columns' => ['month', 'amount']
                        ]
                    ],

                    '011' => [
                        'select' => [
                            'table'   => 'order_log',
                            'columns' => ['id', 'completed', 'user_id', 'vp_cost', 'dp_cost', 'cart', 'timestamp']
                        ],

                        'insert' => [
                            'table'   => 'order_log',
                            'columns' => ['id', 'completed', 'user_id', 'vp_cost', 'dp_cost', 'cart', 'timestamp']
                        ]
                    ],

                    '012' => [
                        'select' => [
                            'table'   => 'pages',
                            'columns' => ['id', 'identifier', 'name', 'content', 'permission', 'rank_needed']
                        ],

                        'insert' => [
                            'table'   => 'pages',
                            'columns' => ['id', 'identifier', 'name', 'content', 'permission', 'rank_needed']
                        ]
                    ],

                    '013' => [
                        'select' => [
                            'table'   => 'paypal_donate',
                            'columns' => ['id', 'price', 'tax', 'points']
                        ],

                        'insert' => [
                            'table'   => 'paypal_donate',
                            'columns' => ['id', 'price', 'tax', 'points']
                        ]
                    ],

                    '014' => [
                        'select' => [
                            'table'   => 'paypal_logs',
                            'columns' => ['id', 'user_id', 'payment_id', 'hash', 'total', 'points', 'create_time', 'currency', 'error', 'status', 'invoice_number', 'payer_email', 'token', 'transactions_code']
                        ],

                        'insert' => [
                            'table'   => 'paypal_logs',
                            'columns' => ['id', 'user_id', 'payment_id', 'hash', 'total', 'points', 'create_time', 'currency', 'error', 'status', 'invoice_number', 'payer_email', 'token', 'transactions_code']
                        ]
                    ],

                    '015' => [
                        'select' => [
                            'table'   => 'sideboxes',
                            'columns' => ['id', 'type', 'displayName', 'rank_needed', 'order', 'permission']
                        ],

                        'insert' => [
                            'table'   => 'sideboxes',
                            'columns' => ['id', 'type', 'displayName', 'rank_needed', 'order', 'permission']
                        ]
                    ],

                    '016' => [
                        'select' => [
                            'table'   => 'sideboxes_custom',
                            'columns' => ['sidebox_id', 'content']
                        ],

                        'insert' => [
                            'table'   => 'sideboxes_custom',
                            'columns' => ['sidebox_id', 'content']
                        ]
                    ],

                    '017' => [
                        'select' => [
                            'table'   => 'store_groups',
                            'columns' => ['id', 'title', 'orderNumber']
                        ],

                        'insert' => [
                            'table'   => 'store_groups',
                            'columns' => ['id', 'title', 'orderNumber']
                        ]
                    ],

                    '018' => [
                        'select' => [
                            'table'   => 'store_items',
                            'columns' => ['id', 'itemid', 'name', 'quality', 'vp_price', 'dp_price', 'realm', 'description', 'icon', 'group', 'query', 'query_database', 'query_need_character', 'command', 'command_need_character', 'require_character_offline', 'tooltip']
                        ],

                        'insert' => [
                            'table'   => 'store_items',
                            'columns' => ['id', 'itemid', 'name', 'quality', 'vp_price', 'dp_price', 'realm', 'description', 'icon', 'group', 'query', 'query_database', 'query_need_character', 'command', 'command_need_character', 'require_character_offline', 'tooltip']
                        ]
                    ],

                    '019' => [
                        'select' => [
                            'table'   => 'teleport_locations',
                            'columns' => ['id', 'name', 'description', 'x', 'y', 'z', 'orientation', 'mapId', 'vpCost', 'dpCost', 'goldCost', 'realm', 'required_faction']
                        ],

                        'insert' => [
                            'table'   => 'teleport_locations',
                            'columns' => ['id', 'name', 'description', 'x', 'y', 'z', 'orientation', 'mapId', 'vpCost', 'dpCost', 'goldCost', 'realm', 'required_faction']
                        ]
                    ],

                    '020' => [
                        'select' => [
                            'table'   => 'vote_sites',
                            'columns' => ['id', 'vote_sitename', 'vote_url', 'vote_image', 'hour_interval', 'points_per_vote', 'callback_enabled']
                        ],

                        'insert' => [
                            'table'   => 'vote_sites',
                            'columns' => ['id', 'vote_sitename', 'vote_url', 'vote_image', 'hour_interval', 'points_per_vote', 'callback_enabled']
                        ]
                    ],

                    '021' => [
                        'select' => [
                            'table'   => 'vote_log',
                            'columns' => ['id', 'vote_site_id', 'user_id', 'ip', 'time']
                        ],

                        'insert' => [
                            'table'   => 'vote_log',
                            'columns' => ['id', 'vote_site_id', 'user_id', 'ip', 'time']
                        ]
                    ]
                ]
            ],

            # BlizzCMS v1
            'bcms1' => [
                'info' => [
                    'name'    => 'BlizzCMS v1',
                    'version' => '1.x'
                ],

                'queries' => [
                    '001' => [
                        'select' => [
                            'table'   => 'users',
                            'columns' => ['id', 'vp', 'dp', 'nickname']
                        ],

                        'insert' => [
                            'table'   => 'account_data',
                            'columns' => ['id', 'vp', 'dp', 'nickname']
                        ]
                    ],

                    '002' => [
                        'select' => [
                            'table'   => 'news',
                            'columns' => ['id', 'title', 'description', 'date', 'comments']
                        ],

                        'insert' => [
                            'table'   => 'articles',
                            'columns' => ['id', 'headline', 'content', 'timestamp', 'comments']
                        ]
                    ],

                    '003' => [
                        'select' => [
                            'table'   => 'news_comments',
                            'columns' => ['id', 'id_new', 'author', 'commentary', 'date']
                        ],

                        'insert' => [
                            'table'   => 'comments',
                            'columns' => ['id', 'article_id', 'author_id', 'content', 'timestamp']
                        ]
                    ],

                    '004' => [
                        'select' => [
                            'table'   => 'slides',
                            'columns' => ['id', 'route', 'title', 'description', 'description']
                        ],

                        'insert' => [
                            'table'   => 'image_slider',
                            'columns' => ['id', 'image', 'header', 'text', 'body']
                        ]
                    ],

                    '005' => [
                        'select' => [
                            'table'   => 'changelogs',
                            'columns' => ['id', 'description', 'date']
                        ],

                        'insert' => [
                            'table'   => 'changelog',
                            'columns' => ['change_id', 'changelog', 'time']
                        ]
                    ],

                    '006' => [
                        'select' => [
                            'table'   => 'donate_logs',
                            'columns' => ['id', 'user_id', 'payment_id', 'hash', 'total', 'points', 'create_time', 'status']
                        ],

                        'insert' => [
                            'table'   => 'paypal_logs',
                            'columns' => ['id', 'user_id', 'payment_id', 'hash', 'total', 'points', 'create_time', 'status']
                        ]
                    ],

                    '007' => [
                        'select' => [
                            'table'   => 'votes',
                            'columns' => ['id', 'name', 'url', 'points', 'image']
                        ],

                        'insert' => [
                            'table'   => 'vote_sites',
                            'columns' => ['id', 'vote_sitename', 'vote_url', 'points_per_vote', 'vote_image']
                        ]
                    ],

                    '008' => [
                        'select' => [
                            'table'   => 'votes_logs',
                            'columns' => ['id', 'idaccount', 'idvote', 'lasttime']
                        ],

                        'insert' => [
                            'table'   => 'vote_log',
                            'columns' => ['id', 'user_id', 'vote_site_id', 'time']
                        ]
                    ],

                    '009' => [
                        'select' => [
                            'table'   => 'store_categories',
                            'columns' => ['id', 'name']
                        ],

                        'insert' => [
                            'table'   => 'store_groups',
                            'columns' => ['id', 'title']
                        ]
                    ],

                    '010' => [
                        'select' => [
                            'table'   => 'store_items',
                            'columns' => ['id', 'name', 'category', 'price_dp', 'price_vp', 'itemid', 'icon']
                        ],

                        'insert' => [
                            'table'   => 'store_items',
                            'columns' => ['id', 'name', 'group', 'dp_price', 'vp_price', 'itemid', 'icon']
                        ]
                    ]
                ]
            ],

            # BlizzCMS v2
            'bcms2' => [
                'info' => [
                    'name'    => 'BlizzCMS v2',
                    'version' => '2.x'
                ],

                'queries' => [
                    '001' => [
                            'select' => [
                                'table'   => 'users',
                                'columns' => ['id', 'vp', 'dp', 'nickname']
                            ],

                            'insert' => [
                                'table'   => 'account_data',
                                'columns' => ['id', 'vp', 'dp', 'nickname']
                            ]
                    ],

                    '002' => [
                        'select' => [
                            'table'   => 'news',
                            'columns' => ['id', 'title', 'content', 'created_at', 'comments']
                        ],

                        'insert' => [
                            'table'   => 'articles',
                            'columns' => ['id', 'headline', 'content', 'timestamp', 'comments']
                        ]
                    ],

                    '003' => [
                        'select' => [
                            'table'   => 'news_comments',
                            'columns' => ['id', 'news_id', 'user_id', 'comment_content', 'created_at']
                        ],

                        'insert' => [
                            'table'   => 'comments',
                            'columns' => ['id', 'article_id', 'author_id', 'content', 'timestamp']
                        ]
                    ],

                    '004' => [
                        'select' => [
                            'table'   => 'slides',
                            'columns' => ['id', 'path', 'title', 'description', 'description', 'sort']
                        ],

                        'insert' => [
                            'table'   => 'image_slider',
                            'columns' => ['id', 'image', 'header', 'text', 'body', 'order']
                        ]
                    ],

                    '005' => [
                        'select' => [
                            'table'   => 'pages',
                            'columns' => ['id', 'title', 'content', 'slug']
                        ],

                        'insert' => [
                            'table'   => 'pages',
                            'columns' => ['id', 'name', 'content', 'identifier']
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Install upgrade page
     *
     * @return void
     */
    public function index(): void
    {
        // Page data
        $data = [
            # Metadata
            'css'          => base_url(basename(APPPATH)) . '/modules/install/css/install.css',
            'INSTALL_PATH' => base_url(basename(APPPATH)) . '/modules/install/',

            # Pagedata
            'statements' => $this->statements
        ];

        die($this->load->view('upgrade', $data, true));
    }

    /**
     * Install migrate page (ajax)
     *
     * @return void
     */
    public function migrate(): void
    {
        // Make sure its ajax request
        if(!$this->input->is_ajax_request())
            die('Silence is golden.');

        // Data: Initialize
        $data = [
            # CMS
            'cms' => $this->input->post('cms', true),

            # Table
            'table' => $this->input->post('table', true),

            # Limit
            'limit'  => (int)$this->input->post('limit', true),
            'offset' => (int)$this->input->post('offset', true),

            # Database
            'db_port'     => $this->input->post('db_port', true),
            'db_hostname' => $this->input->post('db_hostname', true),
            'db_username' => $this->input->post('db_username', true),
            'db_password' => $this->input->post('db_password', true),
            'db_database' => $this->input->post('db_database', true)
        ];

        // Data: Invalid cms
        if(!isset($this->statements[$data['cms']]))
        {
            die(json_encode([
                'status'   => 1,
                'response' => 'Invalid cms: ' . $data['cms']
            ]));
        }

        // Data: Invalid table
        if(!isset($this->statements[$data['cms']]['queries'][$data['table']]))
        {
            die(json_encode([
                'status'   => 1,
                'response' => 'Invalid table: ' . $data['table']
            ]));
        }

        try
        {
            // Remote: Initialize
            $remote = [
                'port'     => (int)$data['db_port'],
                'charset'  => 'utf8',
                'DBDriver' => 'MySQLi',
                'DBCollat' => 'utf8_general_ci',
                'hostname' => $data['db_hostname'],
                'username' => $data['db_username'],
                'password' => $data['db_password'],
                'database' => $data['db_database']
            ];

            // Remote: Connect
            $remote = db_connect($remote);

            // Remote: Get version (make sure we connected)
            $remote->getVersion();
        }
        catch(DatabaseException $e)
        {
            die(json_encode([
                'status'   => 1,
                'response' => 'Database connection Error (' . $e->getCode() . ') ' . $e->getMessage()
            ]));
        }

        // Structure: Get
        $structure = $this->statements[$data['cms']]['queries'][$data['table']];

        // SQL: Initialize
        $sql = '';

        // Structure: Loop through columns
        foreach($structure['select']['columns'] as $key => $col)
        {
            // SQL: Append columns
            $sql .= str_replace([':colName', ':colVal'], [$col, $structure['insert']['columns'][$key]], '`:colName` AS `:colVal`, ');

            if ($data['cms'] == 'bcms2' && $col == 'created_at') {

                // SQL: Replace date to timestamp
                $sql = str_replace(['`created_at` AS `timestamp`, '], 'unix_timestamp(`created_at`) AS `timestamp`, ', $sql);
            }
        }

        // SQL: Format
        $sql = str_replace([':COLS', ':TABLE', ':LIMIT', ':OFFSET'], [trim($sql, ', '), $structure['select']['table'], $data['limit'], $data['offset']], 'SELECT :COLS FROM `:TABLE` LIMIT :LIMIT OFFSET :OFFSET');

        try
        {
            // Query: Prepare
            $query = $remote->query($sql);

            // Result: Get
            $result = $query->getNumRows() ? $query->getResultArray() : [];

            // DB: Insert (migrate)
            if($result)
                $this->db->table($structure['insert']['table'])->upsertBatch($result);

            die(json_encode([
                'status'        => 0,
                'response'      => sprintf('[FROM: %s] [TO: %s] Successfully migrated %u rows.', $structure['select']['table'], $structure['insert']['table'], count($result)),
                'affected_rows' => count($result)
            ]));
        }
        catch(DatabaseException $e)
        {
            die(json_encode([
                'status'   => 1,
                'response' => $e->getMessage()
            ]));
        }
    }
}
