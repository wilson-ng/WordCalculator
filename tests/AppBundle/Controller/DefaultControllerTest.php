<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Word Calculator', $crawler->filter('.container h1')->text());
    }

    public function testSubmit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrawlerNode = $crawler->selectButton('Hitung');
        $form = $buttonCrawlerNode->form();
        $crawler = $client->submit($form, [
            'form[stringCalculation]' => 'nol kurang nol',
        ]);

        $this->assertContains('nol kurang nol adalah nol', $crawler->filter('#result')->text());

        $form = $buttonCrawlerNode->form();
        $crawler = $client->submit($form, [
            'form[stringCalculation]' => 'nol kurang dua puluh',
        ]);

        $this->assertContains('nol kurang dua puluh adalah minus dua puluh', $crawler->filter('#result')->text());

        $form = $buttonCrawlerNode->form();
        $crawler = $client->submit($form, [
            'form[stringCalculation]' => 'dua puluh kali dua puluh',
        ]);

        $this->assertContains('dua puluh kali dua puluh adalah empat ratus', $crawler->filter('#result')->text());

        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'form[stringCalculation]' => 'dua puluh satu kali dua puluh',
        ]);
        $crawler = $client->followRedirect();
        $this->assertContains('Nilai valid sisi kiri dan kanan adalah', $crawler->filter('.alert')->text());

        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'form[stringCalculation]' => 'nol kali dua puluh satu',
        ]);
        $crawler = $client->followRedirect();
        $this->assertContains('Nilai valid sisi kiri dan kanan adalah', $crawler->filter('.alert')->text());
        
        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'form[stringCalculation]' => 'noll kali dua puluh',
        ]);
        $crawler = $client->followRedirect();
        $this->assertContains('Nilai valid sisi kiri dan kanan adalah', $crawler->filter('.alert')->text());

        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'form[stringCalculation]' => 'nol kali dua puluhh',
        ]);
        $crawler = $client->followRedirect();
        $this->assertContains('Nilai valid sisi kiri dan kanan adalah', $crawler->filter('.alert')->text());

        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'form[stringCalculation]' => 'nol kalik dua puluh',
        ]);
        $crawler = $client->followRedirect();
        $this->assertContains('Nilai valid sisi kiri dan kanan adalah', $crawler->filter('.alert')->text());
    }
}
