<?php

class QueryBuilderTest extends PHPUnit_Framework_TestCase {

	public function testCanBeNegated() {
		
		$a = WPLDK_Database_QueryBuilder::for_table('test');
		$a->limit(1);

        $this->assertEquals(1, $a->_limit);
    }
}