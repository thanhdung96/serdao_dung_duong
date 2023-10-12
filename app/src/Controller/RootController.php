<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/')]
class RootController extends AbstractController
{

    #[Route(path: '', name: 'default_route', methods: Request::METHOD_GET)]
    public function index(KernelInterface $kernel): Response{
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $migrationCommand = new ArrayInput([
            'command' => 'doctrine:migration:migrate',
            '--no-interaction'
        ]);
        $loadFixtureCommand = new ArrayInput([
            'command' => 'doctrine:fixtures:load',
            '--no-interaction'
        ]);
        $output = new BufferedOutput();

        $application->run($migrationCommand, $output);
        $application->run($loadFixtureCommand, $output);

        return $this->redirectToRoute('user_index');
    }
}