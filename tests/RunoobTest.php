<?php
namespace Elviss\TutorialSpider\Tests;
use PHPUnit\Framework\TestCase;
use Elviss\TutorialSpider\Runoob;

final class RunoobTest  extends TestCase 
{
    public function testGetIndexes() {
       $runoob = new Runoob;
	   $re = $runoob->getIndexes('/html/html-tutorial.html');
	   var_dump($re);
    }
}