<?php

/**
 * Test Test Class.
 */
class DemoTest extends PHPUnit_Framework_TestCase
{
    public function testAuthor()
    {
        $author = 'Nikolai Plath';

        $this->assertSame($author, 'Nikolai Plath');
    }

    public function testArrayKey()
    {
        $data = array(
            'forename' => 'Nikolai',
	        'surname' => 'Plath',
	        'nickname' => 'elkuku'
        );

        $this->assertArrayHasKey('nickname', $data);
        $this->assertArrayHasKey('forename', $data);
        $this->assertArrayHasKey('surname', $data);
    }

    public function testObjectAttribute()
    {
        $object = new stdClass;

	    $object->forename = 'Nikolai';
	    $object->surname = 'Plath';
	    $object->nickname = 'elkuku';

        $this->assertObjectHasAttribute('nickname', $object);
        $this->assertObjectHasAttribute('forename', $object);
        $this->assertObjectHasAttribute('surname', $object);
    }

	public function testFail()
	{
		$author = 'Sebastian Bergmann';

		$this->assertSame($author, 'Nikolai Plath =;)');
	}
}
