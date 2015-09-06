<?php

namespace CodeIgniter\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
* A controller make command
*/
class MakeModelCommand extends Command
{
	
	public function __construct()
	{
		parent::__construct();
	}

	protected function configure()
	{
		$this->setName('make:model')
			->setDescription('Create a new model')
			->addArgument(
				'name',
				InputArgument::REQUIRED,
				'The name of the model class'
			)
			->addOption(
				'suffix',
				NULL,
				InputOption::VALUE_OPTIONAL,
				'Default: _m, the model suffix will be relaced with the defined'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$name = $input->getArgument('name');

		$suffix = $input->getOption('suffix') ?: '_m';

		$this->make($name, $suffix, $output);
	}

	private function make($model, $suffix, OutputInterface $output)
	{
		$stub = file_get_contents(dirname(__FILE__).'/stubs/controller.stub');
		$model = ucfirst($model) . $suffix;

		$file = str_replace('{{class}}', ucfirst($model), $stub);

		if( ! file_exists($fullPath = "./application/models/{$model}.php") ) 
		{
			file_put_contents($fullPath, $file);
			$output->writeln("<info>Model created successfully!</info>");
		}
		else
		{
			$output->writeln('<error>Model already exists.</error>');
		}

		return false;

	}


}