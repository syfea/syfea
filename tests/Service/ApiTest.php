<?php
/**
 * Created by PhpStorm.
 * User: syfea
 * Date: 09/05/19
 * Time: 10:14
 */
namespace App\Service\Service;

use App\Service\Api;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    public function testGetCategory()
    {
        $api = new Api();
        $this->assertObjectHasAttribute('articles', $api->getCategory());
    }
}