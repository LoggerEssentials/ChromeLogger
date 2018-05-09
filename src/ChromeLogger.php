<?php
namespace Logger;

use ChromePhp;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class ChromeLogger extends AbstractLogger {
	/**
	 * Logs with an arbitrary level.
	 *
	 * @param mixed $level
	 * @param string $message
	 * @param array $context
	 */
	public function log($level, $message, array $context = array()) {
		$logger = 'log';
		
		switch($level) {
			case LogLevel::EMERGENCY: $logger = 'error'; break;
			case LogLevel::ALERT: $logger = 'error'; break;
			case LogLevel::CRITICAL: $logger = 'error'; break;
			case LogLevel::ERROR: $logger = 'error'; break;
			case LogLevel::WARNING: $logger = 'warn'; break;
			case LogLevel::NOTICE: $logger = 'warn'; break;
			case LogLevel::INFO: $logger = 'log'; break;
			case LogLevel::DEBUG: $logger = 'log'; break;
		}
		
		$backtrace = debug_backtrace(false);
		$level = 0;
		foreach($backtrace as $level => $stack) {
			if(array_key_exists('class', $stack)) {
				$class = '\\' . ltrim($stack['class'], '\\');
				if(!($this->startsWith($class, '\\Psr\\Log\\') || $this->startsWith($class, '\\Logger\\'))) {
					break;
				}
			}
		}
		
		ChromePhp::getInstance()->addSetting(ChromePhp::BACKTRACE_LEVEL, $level + 3);
		call_user_func([ChromePhp::class, $logger], $message, $context);
	}
	
	/**
	 * @param string $subject
	 * @param string $prefix
	 * @return bool
	 */
	private function startsWith($subject, $prefix) {
		return substr($subject, 0, strlen($prefix)) === $prefix;
	}
}
