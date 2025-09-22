<?php

namespace Tests\Integration\API;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\LinkFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class LinkAPITest extends ApiTestCase
{

    use ResetDatabase, Factories;

    public function setUp(): void
    {
        self::bootKernel();
    }

    public function testGetCollection() {

        LinkFactory::createMany(100);

        $response = static::createClient()->request('GET', '/api/links');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            '@context' => '/api/contexts/Link',
            '@id' => '/api/links',
            '@type' => 'Collection',
            'totalItems' => 100,
            'view' => [
                '@id' => '/api/links?page=1',
                '@type' => 'PartialCollectionView',
                'first' => '/api/links?page=1',
                'last' => '/api/links?page=4',
                'next' => '/api/links?page=2',
            ],
        ]);
    }
}
