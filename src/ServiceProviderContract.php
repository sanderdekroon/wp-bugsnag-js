<?php

declare(strict_types=1);

namespace Sanderdekroon\BugsnagJs;

interface ServiceProviderContract
{
    public function boot(): void;
    public function register(): void;
}
