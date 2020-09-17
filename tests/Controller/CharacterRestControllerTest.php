<?php
// tests/Controller/CharacterRestControllerTest.php

namespace App\Tests\Controller;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterRestControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/character');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertCount(2, $data);
        $this->assertCount(5, $data['characters']);
        $this->assertCount(16, $data['pagination']);
    }

    public function testCreate()
    {
        $client = static::createClient();

        $headers = [
            'CONTENT_TYPE' => 'application/json',
        ];

        $content = [
            'name' => 'TEST1',
            'episodes' =>['EMPIRE'],
            'planet' => 'Alderaan',
            'friends' =>['C-3PO'],
        ];

        $client->request(
            'POST',
            '/api/v1/character',
            [],
            [],
            $headers,
            json_encode($content));

        $this->assertSuccess($client);
    }

    public function testRead()
    {
        $client = static::createClient();

        /** @var CharacterRepository $repository */
        $repository = $this->characterRepository($client);

        $characters = $repository->findAll();

        /** @var Character $character */
        foreach ($characters as $character) {
            $client->request('GET', '/api/v1/character/' . $character->getId());

            $this->assertSuccess($client);
        }
    }

    public function testUpdate()
    {
        $client = static::createClient();

        /** @var CharacterRepository $repository */
        $repository = $this->characterRepository($client);

        /** @var Character $character */
        $character = $repository->findOneBy(['name' => 'TEST1']);

        $headers = [
            'CONTENT_TYPE' => 'application/json',
        ];

        $content = [
            'name' => 'TEST2',
            'episodes' =>['EMPIRE'],
            'planet' => 'Alderaan',
            'friends' =>['C-3PO'],
        ];

        $client->request(
            'PUT',
            '/api/v1/character/' . $character->getId(),
            [],
            [],
            $headers,
            json_encode($content));

        $this->assertSuccess($client);
    }

    public function testDelete()
    {
        $client = static::createClient();

        /** @var CharacterRepository $repository */
        $repository = $this->characterRepository($client);

        /** @var Character $character */
        $character = $repository->findOneBy(['name' => 'TEST2']);

        $client->request('DELETE', '/api/v1/character/' . $character->getId());

        $this->assertSuccess($client);
    }

    private function assertSuccess(KernelBrowser $client)
    {
        $response = json_decode($client->getResponse()->getContent(), true);

        $statusCode = $client->getResponse()->getStatusCode();

        $this->assertEquals(200, $statusCode);
        $this->assertEquals('SUCCESS', $response['result']);
    }

    private function characterRepository(KernelBrowser $client)
    {
        return $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Character::class);
    }
}
