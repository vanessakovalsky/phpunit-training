<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{

    public $fixtures;

    public function setUp() : void
    {
        $this->fixtures = [
            'email' => 'v.david@kovalibre.com',
            'password' => 'symfony0520'
        ];
    }
    
    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');
    }

    public function testLoginSend(): void
    {
        $client = static::createClient();
        $data = $this->fixtures;
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
	    $form = $crawler->selectButton('Sign in')->form();
        $form['email']->setValue($data['email']);
        $form['password']->setValue($data['password']);
        $client->submit($form);

        $client->followRedirect();

        $this->assertSelectorTextContains('body', 'Bienvenue');
        $this->assertResponseIsSuccessful();

    }
}
