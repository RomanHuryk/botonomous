<?php

namespace Slackbot;

use Slackbot\Tests\PhpunitHelper;

/** @noinspection PhpUndefinedClassInspection */
class BlackListTest extends \PHPUnit_Framework_TestCase
{
    private function getBlackList()
    {
        return (new PhpunitHelper())->getBlackList();
    }

    public function testIsUsernameBlackListed()
    {
        $inputsOutputs = [
            [
                'input' => [
                    'access-control' => [
                        'blacklist' => [
                            'userId' => [],
                        ],
                    ],
                ],
                'output' => null,
            ],
            [
                'input'  => (new PhpunitHelper())->getDictionaryData('blacklist'),
                'output' => true,
            ],
            [
                'input' => [
                    'access-control' => [
                        'blacklist' => [
                            'username' => [],
                            'userId'   => [],
                        ],
                    ],
                ],
                'output' => false,
            ],
            [
                'input' => [
                    'access-control' => [
                        'blacklist' => [
                            'username' => [
                                'blahblah',
                            ],
                            'userId' => [
                                'blahblah',
                            ],
                        ],
                    ],
                ],
                'output' => false,
            ],
        ];

        $blacklist = $this->getBlackList();
        $dictionary = new Dictionary();
        foreach ($inputsOutputs as $inputOutput) {
            $dictionary->setData($inputOutput['input']);

            // set the dictionary
            $blacklist->setDictionary($dictionary);

            $this->assertEquals($inputOutput['output'], $blacklist->isUsernameBlackListed());
        }
    }

    public function testIsUserIdBlackListed()
    {
        $inputsOutputs = [
            [
                'input' => [
                    'access-control' => [
                        'blacklist' => [
                            'username' => [],
                        ],
                    ],
                ],
                'output' => null,
            ],
            [
                'input' => [
                    'access-control' => [
                        'blacklist' => [
                            'username' => [],
                            'userId'   => [
                                'dummyUserId',
                            ],
                        ],
                    ],
                ],
                'output' => true,
            ],
            [
                'input' => [
                    'access-control' => [
                        'blacklist' => [
                            'username' => [],
                            'userId'   => [],
                        ],
                    ],
                ],
                'output' => false,
            ],
            [
                'input' => [
                    'access-control' => [
                        'blacklist' => [
                            'username' => [],
                            'userId'   => [
                                'blahblah',
                            ],
                        ],
                    ],
                ],
                'output' => false,
            ],
        ];

        $blacklist = $this->getBlackList();
        $dictionary = new Dictionary();
        foreach ($inputsOutputs as $inputOutput) {
            $dictionary->setData($inputOutput['input']);

            // set the dictionary
            $blacklist->setDictionary($dictionary);

            $this->assertEquals($inputOutput['output'], $blacklist->isUserIdBlackListed());
        }
    }

    public function testIsBlackListed()
    {
        $whitelist = $this->getBlackList();
        $this->assertEquals(false, $whitelist->isBlackListed());
    }
}