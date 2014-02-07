<?php

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: 08.07.2013
 * Time: 16:30:00
 * Format: http://book.cakephp.org/2.0/en/console-and-shells.html#creating-a-shell
 */
App::uses('AppMonitoringShell', 'Monitoring.Console/Command');

/**
 * @package Monitoring.Console.Command
 */
class MonitoringShell extends AppMonitoringShell {

	public $enabledTasks = array(
		'Checkers',
		'RunChecker'
	);

	public function getOptionParser() {
		$parser = parent::getOptionParser();
		$parser->description('Monitoring shell options');

		foreach ($this->enabledTasks as $taskName) {
			$parser->addSubcommand(Inflector::underscore($taskName), array(
				'help' => $this->Tasks->load($this->pluginName . '.' . $taskName)->getOptionParser()->description(),
				'parser' => $this->Tasks->load($this->pluginName . '.' . $taskName)->getOptionParser()
			));
		}
		return $parser;
	}

	public function startup() {
		if (!$this->params['silent']) {
			parent::startup();
		}
	}

}
