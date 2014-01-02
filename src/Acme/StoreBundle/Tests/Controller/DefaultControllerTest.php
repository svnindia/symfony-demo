<?php
//phpunit --coverage-html=cov -c symfony_demo/app/ symfony_demo/src/Acme/StoreBundle/Tests/Controller/
namespace Acme\StoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DemoControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/store/');
        $this->assertGreaterThan(0,$crawler->filter('html:contains("Hello found two!")')->count());
    }
    public function testNew()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/store/new');
        
		$form = $crawler->selectButton('form[save]')->form();
		// set some values
		$form['form[name]'] = 'Jim';
		$form['form[price]'] = '46';
		// submit the form
		$crawler = $client->submit($form);
		$crawler = $client->followRedirect();
        $this->assertGreaterThan(0,$crawler->filter('html:contains("Product Name Jim!")')->count());
    }
}
