<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    public function __construct(
        string $name = null,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        parent::__construct($name);
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure()
    {
        $this->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $output->writeln('You are about to create an admin user.');

        $usernameQuestion = new Question('Pick a username: ');

        $passwordQuestion = new Question('Pick a password: ');
        $passwordQuestion
            ->setHidden(true)
            ->setHiddenFallback(false);

        $confirmQuestion = new Question('Confirm password: ');
        $confirmQuestion
            ->setHidden(true)
            ->setHiddenFallback(false);

        $helper = $this->getHelper('question');
        $username = $helper->ask($input, $output, $usernameQuestion);

        $password = $helper->ask($input, $output, $passwordQuestion);
        $confirm = $helper->ask($input, $output, $confirmQuestion);

        while ($password != $confirm) {
            $output->writeln('Passwords do not match');

            $password = $helper->ask($input, $output, $passwordQuestion);
            $confirm = $helper->ask($input, $output, $confirmQuestion);
        }

        $user = new User();

        $user->setUsername($username);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $user->setRoles(['ROLE_SUPER_ADMIN']);

        $this->userRepository->save($user);

        $output->writeln('User created successfully!');

        return 0;
    }
}
