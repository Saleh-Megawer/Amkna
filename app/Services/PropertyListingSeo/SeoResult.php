<?php

namespace App\Services\PropertyListingSeo;

class SeoResult
{
    public function __construct(
        public readonly string $pageTitle,
        public readonly string $heading,
        public readonly string $metaDescription,
    ) {
    }
}
