<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Factory;

use DateTimeImmutable;

abstract class AbstractFactory
{
//    protected function extractString(string $key, array $data): ?string
//    {
//        return $data[$key];
//    }

    protected function extractStringOrNull(string $key, array $data): ?string
    {
        return $this->extractOrNull($key, $data);
    }

    protected function extractInteger(string $key, array $data): int
    {
        return (int)$data[$key];
    }

    protected function extractFloat(string $key, array $data): float
    {
        return (float)$data[$key];
    }

    protected function extractBoolean(string $key, array $data): bool
    {
        return (bool)$this->extractOrNull($key, $data);
    }

    protected function extractArrayOrNull(string $key, array $data): ?array
    {
        return $this->extractOrNull($key, $data);
    }

    protected function extractDateTimeImmutableOrNull(string $key, array $data): ?DateTimeImmutable
    {
        $dateTime = $this->extractStringOrNull($key, $data);

        if ($dateTime) {
            return new DateTimeImmutable($dateTime);
        }

        return null;
    }

    private function extractOrNull(string $key, array $data)
    {
        if (array_key_exists($key, $data)) {
            return $data[$key];
        }

        return null;
    }
}
