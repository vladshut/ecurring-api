<?php

declare(strict_types=1);

namespace VladShut\eCurring\Http\Resource;

interface CreateParserInterface
{
    public function parse(Creatable $object): array;
}
