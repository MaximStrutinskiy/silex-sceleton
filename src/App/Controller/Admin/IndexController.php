<?php

namespace App\Controller\Admin;

use Silex\Application;

/**
 * Class IndexController
 * @package App\Controller\Admin
 */
class IndexController
{

	/**
	 * @param Application $app
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function indexAction(Application $app)
	{
		$token = $app['security.token_storage']->getToken();
		$user = null;

		if ($token !== null) {
			$user = $token->getUser();
		}

		if (!$app['security.authorization_checker']->isGranted('ROLE_ADMIN')) {
			return $app->redirect($app['url_generator']->generate('login'));
		} else {
			return $app['twig']->render('admin/page/index.html.twig',
				[
					'user' => $user,
				]
			);
		}
	}
}