<?php

namespace App\Controller\User;

use App\Entity\User;
use Silex\Application;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class UserController
 * @package App\Controller\User
 */
class UserController
{
	/**
	 * @param Application $app
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function registerAction(Application $app, Request $request)
	{
		$user = new User();
		$form = $app['form.factory']->createBuilder(FormType::class, $user)
			->add('email', EmailType::class, [
				'label' => 'Електронный адрес',
			])
			->add('username', TextType::class, [
				'label' => 'Имя пользователя',
			])
			->add('password', RepeatedType::class, [
				'type' => PasswordType::class,
				'first_options' => ['label' => 'Пароль'],
				'second_options' => ['label' => 'Повторите пароль'],
			])
			->getForm();
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();
			$user->setUsername($data->getUsername());
			$user->setEmail($data->getEmail());
			$user->setPassword($app['encode_password']->encodePassword($data->getPassword(), ''));
			$user->setRoles('ROLE_USER');
			$user->setEnabled(true);
			$user->setCreatedAt(new \DateTime('now', new \DateTimeZone('Europe/Kiev')));
			$user->setUpdatedAt(new \DateTime('now', new \DateTimeZone('Europe/Kiev')));
			$app['orm.em']->persist($user);
			$app['orm.em']->flush();
			$token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
			$app['security.token_storage']->setToken($token); // set token_storage
			$app['session']->set('_security_main', serialize($token)); // set session

			return $app->redirect($app['url_generator']->generate('profile'));
		}

		return $app['twig']->render(
			'user/page/register.html.twig',
			[
				'form' => $form->createView()
			]
		);
	}

	/**
	 * @param Application $app
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function loginAction(Application $app, Request $request)
	{
		$form = $app['form.factory']->createNamedBuilder(null)
			->add('_username', TextType::class, [
				'label' => 'Имя пользователя',
			])
			->add('_password', PasswordType::class, [
				'label' => 'Пароль'
			])
			->getForm();
		$form->handleRequest($request);

		if ($form->isSubmitted()) {
			$date = $form->getData();
			$username = $date['_username'];
			$password = $app['encode_password']->encodePassword($date['_password'], '');
			$user = $app['users']->loadUserByUsername($username);

			if (!$user) {
				return $app->redirect($app['url_generator']->generate('login'));
			}

			if ($user->getUsername() == $username && $user->getPassword() == $password) {
				$token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
				$app['security.token_storage']->setToken($token);
				$app['session']->set('_security_main', serialize($token));

				return $app->redirect($app['url_generator']->generate('profile'));
			}

			return $app->redirect($app['url_generator']->generate('login'));
		}

		return $app['twig']->render('user/page/login.html.twig',
			[
				'form' => $form->createView(),
				'error' => $app['security.last_error']($request),
			]
		);
	}

	/**
	 * @param Application $app
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function profileAction(Application $app)
	{
		$token = $app['security.token_storage']->getToken();

		if (null === $user = $app['session']->get('_security_main')) {
			return $app->redirect($app['url_generator']->generate('login'));
		}

		return $app['twig']->render('user/page/profile.html.twig', [
			'user' => $token->getUser(),
		]);
	}
}