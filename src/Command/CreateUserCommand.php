<?php
namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class CreateUserCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';
    private $em;
    private $userRepository;
    private $userPasswordEncoder;

    public function __construct(
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $userPasswordEncoder,
        UserRepository $userRepository
    ) {
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
        parent::__construct();
    }


    protected function configure()
    {
       $this
            ->setDescription('This command allows you to create a user')
            ->setHelp('This command allows you create a user')
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'admin\'s email'
            )
            ->addArgument(
                'password',
                InputArgument::REQUIRED,
                'admin\'s password'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<fg=white; bg=cyan>User creator</>');
        
        $email = $input->getArgument('email');
        $plainPassword = $input->getArgument('password');

        $user = $this->userRepository->findOneByEmail($email);
        if (!empty($user)) {
            $output->writeln('<error> That user already exists</error>');
            return;
        }
        $user = new User();
        $user->setEmail($email);
        $password = $this->userPasswordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($password);
        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('<fg=white;bg=green> User created!</>');
        // this method must return an integer number with the "exit status code"
        // of the command.

        // return this if there was no problem running the command
        return 0;

        // or return this if some error happened during the execution
        // return 1;
    }
}