<?php

declare(strict_types=1);

namespace Sanderdekroon\BugsnagJs\Utility;

class Notices
{
    protected array $storage = [];

    public function addSuccess(string $message): Notices
    {
        return $this->add($message, true);
    }

    public function addFailure(string $message): Notices
    {
        return $this->add($message, false);
    }

    public function add(string $message, bool $positive = true): Notices
    {
        $this->storage[] = compact('message', 'positive');

        return $this;
    }

    public function get(): array
    {
        return $this->storage;
    }
}
