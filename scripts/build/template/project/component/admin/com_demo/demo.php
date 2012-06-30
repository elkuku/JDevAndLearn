<?php
/**
 * @package    TEST
 *
 * @copyright  3000 nope..
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Demo class.
 *
 * @package  Demo
 * @since    0
 */
class Demo
{
	/**
	 * Foo function.
	 *
	 * @param   boolean  $unusedParameterTEST  Unused param test
	 *
	 * @todo: Write some code here..
	 *
	 * @return boolean
	 */
	public function foo($unusedParameterTEST)
	{
		echo 'bar';

		//this is a teenitiny checkstyle error :P

		return false;
	}

	/**
	 * Test.
	 *
	 * @return stdClass
	 */
	public function copyAndPasteTest1()
	{
		$parser = new EcrSqlParser($this->query->processed, 'MySQL');

		$parsed = $parser->parseCreate();

		$result = new stdClass;

		$result->name = $parsed['table_names'][0];

		$result->fields = array();

		foreach ($parsed['column_defs'] as $name => $defs)
		{
			$d = new stdClass;
			$d->type = (isset($defs['type'])) ? $defs['type'] : '';
			$d->length = (isset($defs['length'])) ? $defs['length'] : '';
			$d->constraints = $defs['constraints'];

			$result->fields[$name] = $d;

			$d = new stdClass;
			$d->type = (isset($defs['type'])) ? $defs['type'] : '';
			$d->length = (isset($defs['length'])) ? $defs['length'] : '';
			$d->constraints = $defs['constraints'];

			$result->fields[$name] = $d;
		}

		$result->raw = $this->query->raw;

		return $result;
	}

	/**
	 * Test.
	 *
	 * @return stdClass
	 */
	public function copyAndPasteTest2()
	{
		$parser = new EcrSqlParser($this->query->processed, 'MySQL');

		$parsed = $parser->parseCreate();

		$result = new stdClass;

		$result->name = $parsed['table_names'][0];

		$result->fields = array();

		foreach ($parsed['column_defs'] as $name => $defs)
		{
			$d = new stdClass;
			$d->type = (isset($defs['type'])) ? $defs['type'] : '';
			$d->length = (isset($defs['length'])) ? $defs['length'] : '';
			$d->constraints = $defs['constraints'];

			$result->fields[$name] = $d;

			$d = new stdClass;
			$d->type = (isset($defs['type'])) ? $defs['type'] : '';
			$d->length = (isset($defs['length'])) ? $defs['length'] : '';
			$d->constraints = $defs['constraints'];

			$result->fields[$name] = $d;
		}

		$result->raw = $this->query->raw;

		return $result;
	}
}
