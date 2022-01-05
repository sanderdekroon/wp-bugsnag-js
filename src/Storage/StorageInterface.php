<?php

declare(strict_types=1);

namespace Sanderdekroon\BugsnagJs\Storage;

interface StorageInterface
{
    public function get(string $name, $default = null);
    public function has(string $name): bool;
    public function update(string $name, $value): bool;
    public function save(string $name, $value): bool;
    public function delete(string $name): bool;
}
