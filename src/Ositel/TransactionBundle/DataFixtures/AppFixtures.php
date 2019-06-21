<?php
/**
 * Created by PhpStorm.
 * User: gourram
 * Date: 2019-06-19
 * Time: 20:37
 */

namespace Ositel\TransactionBundle\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Ositel\TransactionBundle\Entity\Category;
use Ositel\TransactionBundle\Entity\Tag;
use Ositel\TransactionBundle\Entity\Transaction;

/**
 * Class AppFixtures
 *
 * @package Ositel\TransactionBundle\DataFixtures
 */
class AppFixtures extends Fixture
{
    const TAG_REFERENCE = 'tag-%s';
    const CATEGORY_REFERENCE = 'category-%s';
    const TRANSACTION_REFERENCE = 'transaction-%s';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $this->loadTags($manager, $faker);
        $this->loadCategories($manager, $faker);
        $this->loadTransactions($manager, $faker);
    }

    /**
     * @param ObjectManager $manager
     * @param Generator     $faker
     */
    private function loadTags(ObjectManager $manager, Generator $faker)
    {
        for ($i = 0;  $i < 10; $i++) {
            $tag = new Tag();
            $tag->setName($faker->slug(1));
            $manager->persist($tag);

            $this->addReference(sprintf(self::TAG_REFERENCE, $i), $tag);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param Generator     $faker
     */
    private function loadCategories(ObjectManager $manager, Generator $faker)
    {

        for ($i = 0;  $i < 10; $i++) {
            $category = new Category();
            $category->setTitle($faker->userName());
            $manager->persist($category);

            $this->addReference(sprintf(self::CATEGORY_REFERENCE, $i), $category);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param Generator     $faker
     */
    private function loadTransactions(ObjectManager $manager, Generator $faker)
    {

        for ($i = 0;  $i < 10; $i++) {
            $transaction = new Transaction();
            $transaction->setTitle($faker->title());
            $transaction->setAmount($faker->randomFloat(2));
            $transaction->setCreatedAt($faker->dateTime());
            $transaction->setDescription($faker->text());
            $transaction->setCategory($this->getReference(sprintf(self::CATEGORY_REFERENCE, $faker->randomNumber(1))));

            $manager->persist($transaction);

            $this->addReference(sprintf(self::TRANSACTION_REFERENCE, $i), $transaction);
        }

        $manager->flush();
    }
}
