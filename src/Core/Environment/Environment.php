<?php namespace Atomino\Core\Environment;

use Composer\Autoload\ClassLoader;

class Environment implements EnvironmentInterface{
	const CONTEXT_WEB = 'web';
	const CONTEXT_CLI = 'cli';
	const MODE_DEV = 'dev';
	const MODE_PROD = 'prod';

	private string $root;
	private string $context;
	private string $mode;

	public function __construct( string $root, private ClassLoader $classLoader){
		$this->root = realpath($root) . '/';
		$this->context = ( http_response_code() ? static::CONTEXT_WEB : self::CONTEXT_CLI );
		$this->mode = file_exists($this->root . '.devmode') ? self::MODE_DEV : self::MODE_PROD;
	}
	public function getRoot(): string{ return $this->root; }
	public function isCli(): bool{ return $this->context === self::CONTEXT_CLI; }
	public function isWeb(): bool{ return $this->context === self::CONTEXT_WEB; }
	public function isDev(): bool{ return $this->mode === self::MODE_DEV; }
	public function isProd(): bool{ return $this->mode === self::MODE_PROD; }
	public function getClassLoader(): ClassLoader{return $this->classLoader;}

}
