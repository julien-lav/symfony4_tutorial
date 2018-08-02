<?php

namespace App\Command;


use App\Entity\User;
use App\Manager\UserManager;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppUserCountTutorialsCommand extends Command
{
    protected static $defaultName = 'app:user-count-tutorials';
    private $userManager;

    public function __construct(UserManager $userManager)   
    {
        $this->userManager = $userManager; 
        parent::__construct();   
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('email', InputArgument::REQUIRED, 'email needed')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');

        $user = $this->userManager->getUserByEmail($email);
        
        if($user == null){
           $io->note(sprintf('Did you write it properly ? => '. $email));;
           $io->error('No User with that email');
        } else {
           $count = $this->userManager->getUserTotalArticles($email);
           $io->note(sprintf('You passed an argument: %s', $email));
           $io->success(sprintf('L\'utilisateur a rédigé %s articles', $count));
       }
   }
}
