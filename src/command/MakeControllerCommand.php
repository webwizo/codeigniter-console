<?php

namespace CodeIgniter\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
* A controller make command
*/
class MakeControllerCommand extends Command
{
	
	public function __construct()
	{
		parent::__construct();
	}

	protected function configure()
	{
		$this->setName('make:controller')
			->setDescription('Create a new controller')
			->addArgument(
				'name',
				InputArgument::REQUIRED,
				'The name of the controller class'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$name = $input->getArgument('name');

		$this->make($name, $output);
	}

	private function make($controller, OutputInterface $output)
	{
		$stub = file_get_contents(dirname(__FILE__).'/stubs/controller.stub');
		$controller = ucfirst($controller);

		$file = str_replace('{{class}}', ucfirst($controller), $stub);

		if( ! file_exists($fullPath = "./application/controllers/{$controller}.php") ) 
		{
			file_put_contents($fullPath, $file);
			$output->writeln("<info>Controller created successfully!</info>");
		}
		else
		{
			$output->writeln('<error>Controller already exists.</error>');
		}

		return false;

	}

}