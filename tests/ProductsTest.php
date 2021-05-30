<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class ProductsTest extends ApiTestCase
{
    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/api/products', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }
}
