<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @group functional
 */
class SecuritySucessRedirectControllerTest extends WebTestCase
{
    public function testRegisterSucessRedirect()
    {
    	$client = static::createClient();
        $crawler = $client->request('GET', '/security/signup');
        self::assertSame('Register', $crawler->filter('h1')->text());
    }
    
    public function testLoginSucessRedirect()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/security/signin');
        self::assertSame('Login', $crawler->filter('h1')->text());
    }
    
    public function testLostPasswordSucessRedirect()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/security/lost');
        self::assertSame('Forgotten password', $crawler->filter('h1')->text());
    }
    
    public function testResetPasswordSucessRedirect()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/security/reset/1');
        self::assertSame('Reset password', $crawler->filter('h1')->text());
    }

}