<?php

namespace Test\Fei\Service\Connect\Common\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Fei\Service\Connect\Common\Entity\Application;
use Fei\Service\Connect\Common\Entity\Attribution;
use Fei\Service\Connect\Common\Entity\Role;
use Fei\Service\Connect\Common\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 *
 * @package Test\Fei\Service\Connect\Entity
 */
class UserTest extends TestCase
{
    public function testUserNameAccessors()
    {
        $user = new User();

        $user->setUserName('test');

        $this->assertEquals('test', $user->getUserName());
        $this->assertAttributeEquals($user->getUserName(), 'userName', $user);
    }

    public function testPasswordAccessors()
    {
        $user = new User();

        $user->setPassword('test');

        $this->assertEquals('test', $user->getPassword());
        $this->assertAttributeEquals($user->getPassword(), 'password', $user);
    }

    public function testFirstNameAccessors()
    {
        $user = new User();

        $user->setFirstName('test');

        $this->assertEquals('test', $user->getFirstName());
        $this->assertAttributeEquals($user->getFirstName(), 'firstName', $user);
    }

    public function testLastNameAccessors()
    {
        $user = new User();

        $user->setLastName('test');

        $this->assertEquals('test', $user->getLastName());
        $this->assertAttributeEquals($user->getLastName(), 'lastName', $user);
    }

    public function testEmailAccessors()
    {
        $user = new User();

        $user->setEmail('test');

        $this->assertEquals('test', $user->getEmail());
        $this->assertAttributeEquals($user->getEmail(), 'email', $user);
    }

    public function testAttributionAccessors()
    {
        $user = new User();

        $user->setAttributions(
            new ArrayCollection([
                (new Attribution())
                    ->setUser($user)
                    ->setApplication(
                        (new Application())
                            ->setName('application test 1')
                    )
                    ->setRole(
                        (new Role())
                            ->setRole('role test 1')
                    )
            ])
        );

        $this->assertEquals(
            new ArrayCollection([
                (new Attribution())
                    ->setUser($user)
                    ->setApplication(
                        (new Application())
                            ->setName('application test 1')
                    )
                    ->setRole(
                        (new Role())
                            ->setRole('role test 1')
                    )
            ]),
            $user->getAttributions()
        );
        $this->assertAttributeEquals($user->getAttributions(), 'attributions', $user);

        $user->setAttributions(
            new ArrayCollection([
                (new Attribution())
                    ->setUser($user)
                    ->setApplication(
                        (new Application())
                            ->setName('application test 2')
                    )
                    ->setRole(
                        (new Role())
                            ->setRole('role test 2')
                    )
            ])
        );

        $this->assertEquals(
            new ArrayCollection([
                (new Attribution())
                    ->setUser($user)
                    ->setApplication(
                        (new Application())
                            ->setName('application test 2')
                    )
                    ->setRole(
                        (new Role())
                            ->setRole('role test 2')
                    )
            ]),
            $user->getAttributions()
        );
    }

    public function testToArrayEmpty()
    {
        $user = new User();

        $this->assertEquals(
            [
                'id' => null,
                'user_name' => null,
                'first_name' => null,
                'last_name' => null,
                'email' => null,
                'password' => null,
                'created_at' => $user->getCreatedAt()->format(\DateTime::RFC3339),
                'status' => User::STATUS_PENDING,
                'register_token' => null,
                'attributions' => []
            ],
            $user->toArray()
        );
    }

    public function testToArray()
    {
        $user = new User();

        $user->setAttributions(
            new ArrayCollection([
                (new Attribution())
                    ->setId(1)
                    ->setUser($user)
                    ->setApplication(
                        (new Application())
                            ->setId(1)
                            ->setName('application test 1')
                    )
                    ->setRole(
                        (new Role())
                            ->setId(1)
                            ->setRole('role test 1')
                    )
                , (new Attribution())
                    ->setId(2)
                    ->setUser($user)
                    ->setApplication(
                        (new Application())
                            ->setId(2)
                            ->setName('application test 2')
                    )
                    ->setRole(
                        (new Role())
                            ->setId(2)
                            ->setRole('role test 2')
                    )
            ])
        );

        $this->assertEquals(
            [
                'id' => null,
                'user_name' => null,
                'password' => null,
                'first_name' => null,
                'last_name' => null,
                'email' => null,
                'created_at' => $user->getCreatedAt()->format(\DateTime::RFC3339),
                'status' => User::STATUS_PENDING,
                'register_token' => null,
                'attributions' => [
                    [
                        'id' => 1,
                        'application' => [
                            'id' => 1,
                            'name' => 'application test 1',
                            'url' => null
                        ],
                        'role' => [
                            'id' => 1,
                            'role' => 'role test 1'
                        ]
                    ],
                    [
                        'id' => 2,
                        'application' => [
                            'id' => 2,
                            'name' => 'application test 2',
                            'url' => null
                        ],
                        'role' => [
                            'id' => 2,
                            'role' => 'role test 2'
                        ]
                    ]
                ]
            ],
            $user->toArray()
        );
    }

    public function testHydrateRolesEmpty()
    {
        $user = new User([
            'attributions' => []
        ]);

        $this->assertEmpty($user->getAttributions()->toArray());
    }

    public function testHydrate()
    {
        $user = new User([
            'attributions' => [
                [
                    'id' => 1,
                    'application' => [
                        'id' => 1,
                        'name' => 'application test 1'
                    ],
                    'role' => [
                        'id' => 1,
                        'role' => 'role test 1'
                    ]
                ],
                [
                    'id' => 2,
                    'application' => [
                        'id' => 2,
                        'name' => 'application test 2'
                    ],
                    'role' => [
                        'id' => 2,
                        'role' => 'role test 2'
                    ]
                ]
            ]
        ]);

        $this->assertEquals(
            new ArrayCollection([
                (new Attribution())
                    ->setId(1)
                    ->setUser($user)
                    ->setRole(
                        (new Role())
                            ->setId(1)
                            ->setRole('role test 1')
                    )
                    ->setApplication(
                        (new Application())
                            ->setId(1)
                            ->setName('application test 1')
                    ),
                (new Attribution())
                    ->setId(2)
                    ->setUser($user)
                    ->setRole(
                        (new Role())
                            ->setId(2)
                            ->setRole('role test 2')
                    )
                    ->setApplication(
                        (new Application())
                            ->setId(2)
                            ->setName('application test 2')
                    )
            ]),
            $user->getAttributions()
        );
    }
}
