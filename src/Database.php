<?php

declare(strict_types=1);

namespace CampaignManager\CampaignManager;

use Error;

final class Database
{
    private ?\PDO $pdo = null;
    public private(set) array $results = [];

    public function __construct(
        private string $dsn,
        private string $user,
        private string $password
    ) {}

    public function getConnection(): ?self
    {
        if ($this->pdo === null) return null;


        try {
            $this->pdo = new \PDO($this->dsn, $this->user, $this->password);
            return $this;
        } catch (\PDOException $e) {
            print_r($e);
            return null;
        }
    }

    public function resetData(array $tables): self
    {
        foreach ($tables as $table) {
            $this->pdo?->prepare('DELETE FROM ' . $table['table'])->execute();
            $this->pdo?->prepare('ALTER TABLE ' . $table['table'] . ' AUTO_INCREMENT = 1')->execute();
        }

        return $this;
    }

    // Insert Basic Platforms
    public function addPlatforms(array $platforms): self
    {
        $sth = $this->pdo?->prepare('INSERT INTO platform (name, code) values (:name, :code)');

        if ($sth === null) {
            throw new Error("Could not add data");
        };

        foreach ($platforms as $platform) {
            $this->results[$platform['name']] = $sth->execute($platform);
        }

        return $this;
    }

    // Insert Test Clients
    public function addClients(array $clients): self
    {
        $sth = $this->pdo?->prepare('INSERT INTO client (name, domain) values (:name, :domain)');

        if ($sth === null) {
            throw new Error("Could not add data");
        };

        foreach ($clients as $client) {
            $this->results[$client['name']] = $sth->execute($client);
        }

        return $this;
    }

    // Insert Test Users
    public function addUsers(array $users): self
    {
        $sth = $this->pdo?->prepare('INSERT INTO user (email, roles, password) values (:email, :roles, :password)');

        if ($sth === null) {
            throw new Error("Could not add data");
        };

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
