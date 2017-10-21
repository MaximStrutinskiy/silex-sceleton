<?php

namespace App\Command;

use App\Entity\User;
use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateUser extends Command
{
	private $app;

	public function __construct($app, $name = null)
	{
		parent::__construct($name);
		$this->app = $app;
	}

	protected function configure()
	{
		$this
			->setName("app:generate:user")
			->setDescription("Generate User. Set arguments: email, name, password, role. [email(string), name(string), password(string), role(bool) = 'admin' or 'user']")
			->setDefinition([
				new InputArgument(
					'email', InputArgument::REQUIRED, 'Enter user Email.'
				),
				new InputArgument(
					'name', InputArgument::REQUIRED, 'Enter user Name.'
				),
				new InputArgument(
					'password', InputArgument::REQUIRED, 'Enter user Password.'
				),
				new InputArgument(
					'role', InputArgument::REQUIRED, 'Enter user Role.'
				),
			]);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$em = $this->app['orm.em'];
		$email = $input->getArgument('email');
		$name = $input->getArgument('name');
		$password = $input->getArgument('password');
		$role = $input->getArgument('role');

		if (($role != 'user') && (($role != 'admin'))) {
			throw new \InvalidArgumentException(
				sprintf("[Role FieldError] " . $role . " role is note define. Select 'admin' or 'user' role.")
			);
		}

		$user = new User();
		$user->setEmail($email);
		$user->setUsername($name);
		$user->setPassword($this->app['encode_password']->encodePassword($password, ''));
		$user->setEnabled(true);
		$user->setCreatedAt(new \DateTime('now', new \DateTimeZone('Europe/Kiev')));
		$user->setUpdatedAt(new \DateTime('now', new \DateTimeZone('Europe/Kiev')));

		if ($role == 'user') {
			$user->setRoles('ROLE_USER');
		} elseif ($role == 'admin') {
			$user->setRoles('ROLE_ADMIN');
		}

		$em->persist($user);
		$em->flush();

		$output->writeln("User has been created!");
	}
}