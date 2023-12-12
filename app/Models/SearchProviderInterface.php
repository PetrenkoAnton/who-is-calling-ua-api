<?php

namespace App\Models;

interface SearchProviderInterface
{
    public function getName(): string;

    public function getComments(string $phone): array;
}
