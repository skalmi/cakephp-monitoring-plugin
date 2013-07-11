<?

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: 08.07.2013
 * Time: 18:09:32
 * Format: http://book.cakephp.org/2.0/en/development/testing.html
 */

/**
 * @package Monitoring.Test.Case.Model
 */
class MonitoringTest extends CakeTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'plugin.Monitoring.Monitoring',
		'plugin.Monitoring.MonitoringLog'
	);

	/**
	 * Monitoring model
	 *
	 * @var Monitoring
	 */
	public $Monitoring = null;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Monitoring = ClassRegistry::init('Monitoring.Monitoring');
		$this->Monitoring->recursive = -1;

	}

	public function testGetActiveCheckers() {
		$this->Monitoring->save(array(
			'id' => 2,
			'name' => 'Test2',
			'active' => 1,
			'frequency' => 0,
			'priority' => 0,
			'last_check' => date('Y-m-d H:i:s')
		));

		$this->Monitoring->save(array(
			'id' => 3,
			'name' => 'Test3',
			'active' => 1,
			'frequency' => 5,
			'last_check' => date('Y-m-d H:i:s')
		));

		$this->Monitoring->save(array(
			'id' => 4,
			'name' => 'Test4',
			'active' => 1,
			'frequency' => 0,
			'priority' => 1,
			'last_check' => '0000-00-00 00:00:00'
		));

		$checkers = $this->Monitoring->getActiveCheckers();
		$this->assertEquals(4, $checkers[0]['id']);
		$this->assertEquals(2, $checkers[1]['id']);
	}

	public function testSaveCheckResults() {
		$this->Monitoring->saveCheckResults(1, 1, 'BAD', 'Some errors');
		$this->Monitoring->contain(array(
			'MonitoringLog'
		));
		$checker = $this->Monitoring->findById(1);
		debug($checker);
		$this->assertEqual($checker['Monitoring']['last_code_string'], 'BAD');
		$this->assertEqual($checker['MonitoringLog'][1]['code'], 1);
		$this->assertEqual($checker['MonitoringLog'][1]['code_string'], 'BAD');
		$this->assertEqual($checker['MonitoringLog'][1]['stderr'], 'Some errors');
	}


}