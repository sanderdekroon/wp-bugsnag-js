<?php

declare(strict_types=1);

namespace Sanderdekroon\BugsnagJs;

use Closure;
use ReflectionType;
use ReflectionClass;
use RuntimeException;

class Container
{
    /** @var array<int, callable> */
    protected array $bindings = [];

    /**
     * Set an abstract with the given factory.
     * @param string $abstract
     * @param callable|mixed $factory
     */
    public function set(string $abstract, $factory): Container
    {
        if (! is_callable($factory)) {
            $factory = fn() => $factory;
        }

        $this->bindings[$abstract] = $factory;

        return $this;
    }

    /**
     * Get the concretion of the given abstract.
     * @param  string|class-string $abstract
     * @return ($abstract is class-string ? object : mixed)
     */
    public function get(string $abstract)
    {
        if ($this->has($abstract)) {
            return $this->bindings[$abstract]($this);
        }

        return $this->autoBuildAbstract($abstract);
    }

    public function has(string $abstract): bool
    {
        return isset($this->bindings[$abstract]);
    }

    protected function autoBuildAbstract(string $abstract): object
    {
        if (! class_exists($abstract)) {
            throw new RuntimeException("Unable to autobuild {$abstract}: class does not exist");
        }

        $reflection = new ReflectionClass($abstract);
        $dependencies = $this->buildDependencies($reflection);


        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * Build dependencies for the given reflected class.
     * @param  ReflectionClass $reflection
     * @return array<int, mixed>
     */
    protected function buildDependencies(ReflectionClass $reflection): array
    {
        if (! $constructor = $reflection->getConstructor()) {
            return [];
        }

        $parameters = $constructor->getParameters();

        return array_map(function ($parameter) {
            if (! $type = $parameter->getType()) {
                throw new RuntimeException("Unable to infer parameter type");
            }

            return $this->get($this->getReflectionTypeName($type));
        }, $parameters);
    }

    protected function getReflectionTypeName(ReflectionType $type): string
    {
        if ($type instanceof \ReflectionNamedType) {
            return $type->getName();
        }

        if ($type instanceof \ReflectionUnionType) {
            $types = $type->getTypes();

            return $this->getReflectionTypeName(reset($types));
        }

        throw new \InvalidArgumentException("Unkown reflection type " . get_class($type) . ".");
    }
}
