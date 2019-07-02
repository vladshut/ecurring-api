<?php

declare(strict_types=1);

namespace VladShut\eCurring\Tests\Unit\_helpers;

trait TestDataLoaderTrait
{
    protected function getDataFromFile(string $filename): array
    {
        $contents = file_get_contents(self::TEST_FILES_DIR . $filename);

        return json_decode($contents, true);
    }
}
