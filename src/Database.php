<?php

declare(strict_types=1);

namespace CampaignManager\CampaignManager;

use Error;

final class Database
{
    private \PDO $pdo;
    public private(set) array $results = [];

    public function __construct(
        string $dsn,
        string $user,
        string $password
    ) {
        $this->pdo = new \PDO($dsn, $user, $password);
    }

    public function resetData(array $tables): self
    {
        foreach ($tables as $table) {
            $this->pdo->prepare('DELETE FROM ' . $table['table'])->execute();
            $this->pdo->prepare('ALTER TABLE ' . $table['table'] . ' AUTO_INCREMENT = 1')->execute();
        }

        return $this;
    }

    // Insert Basic Platforms
    public function addPlatforms(array $platforms): self
    {
        $sth = $this->pdo->prepare('INSERT INTO platform (name, code) values (:name, :code)');

        foreach ($platforms as $platform) {
            $this->results[$platform['name']] = $sth->execute($platform);
        }

        return $this;
    }

    // Insert Test Clients
    public function addClients(array $clients): self
    {
        $sth = $this->pdo->prepare('INSERT INTO client (name, domain) values (:name, :domain)');

        foreach ($clients as $client) {
            $this->results[$client['name']] = $sth->execute($client);
        }

        return $this;
    }

    // Insert Test Users
    public function addUsers(array $users): self
    {
        $sth = $this->pdo->prepare('INSERT INTO user (email, roles, password) values (:email, :roles, :password)');

        foreach ($users as $user) {
            $user['password'] = password_hash($user['password'], PASSWORD_ARGON2ID);

            $this->results[$user['email']] = $sth->execute($user);
        }

        return $this;
    }

    public function evaluateResults(): ?string
    {
        $failed = array_filter($this->results, fn($insert) => $insert === false);

        if (empty($failed)) {
            return "🚀 All data inserted successfully." . PHP_EOL;
        } else {
            echo "Failed inserts:" . PHP_EOL;
            print_r($failed);
            return null;
        }
    }
}
