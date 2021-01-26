<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\TextContent;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateBaseDataCommand extends Command
{

    const POSTS_TO_CREATE = 20;
    const CATEGORIES_TO_CREATE = 15;

    protected static $defaultName = 'app:create-base-data';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CreateBaseDataCommand constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates base data for categories and posts')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $faker = Factory::create();

        // Delete previous posts and categories so
        $posts = $this->em->getRepository(Post::class)->findAll();
        foreach ( $posts as $post ){
            $this->em->remove($post);
        }

        $categories = $this->em->getRepository(Category::class)->findAll();
        foreach ( $categories as $category ){
            $this->em->remove($category);
        }

        $this->em->flush();


        $categoriesCreated = [];
        for ( $i = 0; $i < self::CATEGORIES_TO_CREATE; $i++ ) {
            $category = new Category();
            $category->setName(ucwords($faker->word()));
            $this->em->persist($category);
            $categoriesCreated[] = $category;
        }

        $this->em->flush();

        for ( $i = 0; $i < self::POSTS_TO_CREATE; $i++ ) {
            $post = new Post();

            $categorySelected = $faker->numberBetween(0, (count($categoriesCreated)-1));

            $post->setCategory($categoriesCreated[$categorySelected]);

            $post->setTitle(ucwords($faker->words(3, true)))
                ->setIntro($faker->text(100))
                ->setPublishDate($faker->dateTime())
                ->setPublished($faker->boolean());

            $numberOfContents = $faker->numberBetween(0, 2);

            for ( $x = 0; $x <= $numberOfContents; $x++ ) {
                $textContent = new TextContent();
                $textContent->setTitle(ucwords($faker->words(3, true)))
                    ->setText($faker->text(400));
                $post->addTextContentList($textContent);
            }

            $this->em->persist($post);
        }

        $this->em->flush();

        $io->success('Finished');

        return 0;
    }
}
