<?php
// src/DataFixtures/LoadFriendData.php

namespace App\DataFixtures;

use App\Entity\Character;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoadFriendData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            LoadCharacterData::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Load this data from external file
        $samples = [
            [
                'friend' => 'Luke Skywalker',
                'friends' => ['Han Solo', 'Leia Organa', 'C-3PO', 'R2-D2'],
            ],
            [
                'friend' => 'Darth Vader',
                'friends' => ['Wilhuff Tarkin'],
            ],
            [
                'friend' => 'Han Solo',
                'friends' => ['Luke Skywalker', 'Leia Organa', 'R2-D2'],
            ],
            [
                'friend' => 'Leia Organa',
                'friends' => ['Luke Skywalker', 'Han Solo', 'C-3PO', 'R2-D2'],
            ],
            [
                'friend' => 'Wilhuff Tarkin',
                'friends' => ['Darth Vader'],
            ],
            [
                'friend' => 'C-3PO',
                'friends' => ['Luke Skywalker', 'Han Solo', 'Leia Organa', 'R2-D2'],
            ],
            [
                'friend' => 'R2-D2',
                'friends' => ['Luke Skywalker', 'Han Solo', 'Leia Organa'],
            ],
        ];

        foreach ($samples as $sample) {
            $character = $this->getCharacter($sample['friend']);

            foreach ($sample['friends'] as $friend) {
                $friend = $this->getCharacter($friend);

                $character->addFriend($friend);

                $manager->flush();
            }
        }
    }

    private function getCharacter(string $name): Character
    {
        /** @var Character $character */
        $character =  $this->getReference('character-' . str_replace(' ', '', $name));

        return $character;
    }
}
