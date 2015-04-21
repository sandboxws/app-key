<?php 

namespace Dutkan\AppKey\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;

class AppKeyCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:key';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate new application key for Laravel Lumen 5.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$key = $this->getRandomKey();

		if ($this->option('show'))
		{
			return $this->line('<comment>'.$this->laravel['config']['app.key'].'</comment>');
		}

		$path = base_path('.env');

		if (file_exists($path))
		{
			file_put_contents($path, str_replace(
				$this->laravel['config']['app.key'], $key, file_get_contents($path)
			));
		}
		else
		{
			if ($this->confirm('".env" file could not be found. Do you want to be generated.? [yes|no]', true))
	        {
	            fopen(base_path('.env'), "w") or die("Unable to open file!");

	            $this->line('<comment>"' . base_path('.env') . '" created environment file.</comment>');

				file_put_contents(base_path('.env'), str_replace(
					$this->laravel['config']['app.key'], $key, file_get_contents(base_path('vendor/dutkan/app-key/src/templates/env.txt'))
				));
	        }
			
		}

		$this->laravel['config']['app.key'] = $key;

		$this->info("Application key [$key] set successfully.");
	}

	/**
	 * Generate a random key for the application.
	 *
	 * @return string
	 */
	protected function getRandomKey()
	{
		return Str::random(32);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['show', null, InputOption::VALUE_NONE, 'Simply display the key instead of modifying files.'],
		];
	}

}