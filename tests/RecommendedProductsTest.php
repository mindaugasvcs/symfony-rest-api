<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\RecommendedProducts;

class RecommendedProductsTest extends ApiTestCase
{
    public function testGetItem(): void
    {
        $response = static::createClient()->request('GET', '/api/products/recommended/vilnius', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['city' => 'vilnius']);
        $this->assertMatchesResourceItemJsonSchema(RecommendedProducts::class);
    }
}
