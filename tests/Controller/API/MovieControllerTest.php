<?php

namespace App\Tests\Controller\API;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();

        $body = '{
          "title": "Test",
          "genre": "Genre",
          "imageSrc": "https://media.pathe.nl/thumb/180x254/gfx_content/posterhr/electraorestes_posterhighres.jpg",
          "showtimes": [
            {
              "showtime": "2020-05-01 11:11:11"
            }
          ]
        }';

        $client->request('POST', '/api/movies/create', [], [], [], $body);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Test', $json['title']);
        $this->assertEquals('Genre', $json['genre']);
    }

    public function testGet()
    {
        $client = static::createClient();

        $client->request('GET', '/api/movies');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertCount(1, $json);

        $client->request('GET', '/api/movies?genre=Genre');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertCount(1, $json);

        $client->request('GET', '/api/movies?title=Tes');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertCount(1, $json);

        $client->request('GET', '/api/movies?title=qweqweqwe');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertCount(0, $json);

        $client->request('GET', '/api/movies/week/18');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertCount(1, $json);
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $body = '{
          "genre": "genretest"
        }';

        $client->request('GET', '/api/movies');

        $client->request('PATCH', '/api/movies/1/edit', [], [], [], $body);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());

        $client->request('GET', '/api/movies/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('genretest', $json['genre']);
    }

    public function testDelete()
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/movies/1/delete');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
