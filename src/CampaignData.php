<?php

declare(strict_types=1);

namespace CampaignManager\CampaignManager;

final class CampaignData
{
    public private(set) array $tables = [
        [
            'table' => 'platform',
        ],
        [
            'table' => 'client',
        ],
        [
            'table' => 'user',
        ]
    ];

    public private(set) array $platforms =  [
        [
            'name' => 'Google Ads Search',
            'code' => 'google-ads-search',
        ],
        [
            'name' => 'Google Ads Display',
            'code' => 'google-ads-display',
        ],
        [
            'name' => 'Instagram',
            'code' => 'instagram',
        ],
        [
            'name' => 'Facebook',
            'code' => 'facebook',
        ],
        [
            'name' => 'YouTube',
            'code' => 'youtube',
        ],
        [
            'name' => 'LinkedIn',
            'code' => 'linkedin',
        ],
        [
            'name' => 'TikTok',
            'code' => 'tiktok',
        ]
    ];

    public private(set) array $clients = [
        [
            'name' => 'Client A',
            'domain' => 'client-a.ch',
        ],
        [
            'name' => 'Client B',
            'domain' => null,
        ],
        [
            'name' => 'Client C',
            'domain' => 'client-c.ch',
        ]
    ];

    public private(set) array $users = [
        [
            'email' => 'project-manager1@mail.com',
            'roles' => '["ROLE_USER", "ROLE_PROJECT_MANAGER"]',
            'password' => 'password',
        ],
        [
            'email' => 'project-manager2@mail.com',
            'roles' => '["ROLE_USER", "ROLE_PROJECT_MANAGER"]',
            'password' => 'password',
        ],
        [
            'email' => 'campaign-owner1@mail.com',
            'roles' => '["ROLE_USER", "ROLE_CAMPAIGN_OWNER"]',
            'password' => 'password',
        ],
        [
            'email' => 'campaign-owners@mail.com',
            'roles' => '["ROLE_USER", "ROLE_CAMPAIGN_OWNER"]',
            'password' => 'password',
        ],
    ];
}
