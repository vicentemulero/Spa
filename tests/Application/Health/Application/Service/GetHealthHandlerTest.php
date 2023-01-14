<?php

declare(strict_types=1);

namespace App\Tests\Application\Health\Application\Service;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetHealthHandlerTest extends WebTestCase
{
    private KernelBrowser $client;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testReturnGetHealthResponseOk(): void
    {
        $this->client->request('GET', '/api/health');

        $this->assertResponseIsSuccessful();
    }
}
