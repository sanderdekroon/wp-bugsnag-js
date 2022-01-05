<?php

declare(strict_types=1);

namespace Sanderdekroon\BugsnagJs;

use Sanderdekroon\BugsnagJs\Storage\StorageInterface;

class ApiKey
{
    protected StorageInterface $storage;
    protected string $storageKey = '_bugsnagjs_api_key';

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function get(): string
    {
        return (string) $this->storage->get($this->storageKey, '');
    }

    public function update(string $apiKey): bool
    {
        return $this->storage->update($this->storageKey, $apiKey);
    }
}
