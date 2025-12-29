<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

/**
 * Development utility script to seed the Symfony Campaign Manager database
 * with basic test data.
 *
 * Warning: This script resets existing data and should only be run in
 * local or testing environments.
 */

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Create database connection
$db = new CampaignManager\CampaignManager\Database(
    dsn: "mysql:host=localhost;dbname=" . $_ENV['db_name'],
    user: $_ENV['db_user'],
    password: $_ENV['db_password']
);

$conn = $db->getConnection();

// Reset tables and insert test data
$campaignData = new CampaignManager\CampaignManager\CampaignData();

$result = $conn
            ->resetData($campaignData->tables)
            ->addPlatforms($campaignData->platforms)
            ->addClients($campaignData->clients)
            ->addUsers($campaignData->users)
            ->evaluateResults()
            ;

echo $result;
