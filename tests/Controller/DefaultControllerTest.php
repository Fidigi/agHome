<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @group functional
 */
class DefaultControllerTest extends WebTestCase
{
    public function testHomepageIsUp()
    {
    	$client = static::createClient();
        $crawler = $client->request('GET', '/');
        self::assertSame('Home page!', $crawler->filter('h1')->text());
    }
    
    public function testAdminpageIsUp()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin');
        self::assertSame('Admin page!', $crawler->filter('h1')->text());
    }
    
    public function testBackpageIsUp()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/back');
        self::assertSame('Back page!', $crawler->filter('h1')->text());
    }
    
    public function testProfilepageIsUp()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/profile');
        self::assertSame('Profile page!', $crawler->filter('h1')->text());
    }

}