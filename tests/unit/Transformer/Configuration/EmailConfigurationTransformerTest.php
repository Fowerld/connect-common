<?php

namespace Test\Fei\Service\Connect\Common\Transformer\Configuration;

use Fei\Service\Connect\Common\Entity\Configuration\Configuration;
use Fei\Service\Connect\Common\Entity\Configuration\EmailConfiguration;
use Fei\Service\Connect\Common\Transformer\Configuration\EmailConfigurationTransformer;
use PHPUnit\Framework\TestCase;

/**
 * Class EmailConfigurationTransformerTest
 *
 * @package Test\Fei\Service\Connect\Common\Transformer\Configuration
 */
class EmailConfigurationTransformerTest extends TestCase
{
    /**
     * @dataProvider dataTransform
     */
    public function testTransform($senderEmail, $subjectPrefix, $bodySignature)
    {
        $transformer = new EmailConfigurationTransformer();

        $configuration = (new EmailConfiguration())
            ->setEmailSender($senderEmail)
            ->setEmailSubjectPrefix($subjectPrefix)
            ->setEmailBodySignature($bodySignature);

        $this->assertEquals(
            [
                EmailConfigurationTransformer::EMAIL_SENDER         => $senderEmail,
                EmailConfigurationTransformer::EMAIL_SUBJECT_PREFIX => $subjectPrefix,
                EmailConfigurationTransformer::EMAIL_BODY_SIGNATURE => $bodySignature
            ],
            $transformer->transform($configuration)
        );
    }

    public function dataTransform()
    {
        return [
            [
                'sender@test.fr',
                'Subject prefix',
                'Body signature',
            ],
            [
                '',
                'Subject prefix',
                'Body signature'
            ],
            [
                'sender@test.fr',
                '',
                'Body signature'
            ],
            [
                'sender@test.fr',
                'Subject prefix',
                ''
            ],
            [
                '',
                '',
                ''
            ]
        ];
    }

    /**
     * @dataProvider dataExtract
     */
    public function testExtract($senderEmail, $subjectPrefix, $bodySignature)
    {
        $transformer = new EmailConfigurationTransformer();

        $this->assertEquals(
            (new EmailConfiguration())
                ->setEmailSender($senderEmail)
                ->setEmailSubjectPrefix($subjectPrefix)
                ->setEmailBodySignature($bodySignature),
            $transformer->extract(
                (new Configuration())
                    ->setKey(EmailConfigurationTransformer::EMAIL_SENDER)
                    ->setValue($senderEmail),
                (new Configuration())
                    ->setKey(EmailConfigurationTransformer::EMAIL_SUBJECT_PREFIX)
                    ->setValue($subjectPrefix),
                (new Configuration())
                    ->setKey(EmailConfigurationTransformer::EMAIL_BODY_SIGNATURE)
                    ->setValue($bodySignature)
            )
        );
    }

    public function dataExtract()
    {
        return [
            [
                'sender@test.fr',
                'Subject prefix',
                'Body signature',
            ],
            [
                '',
                'Subject prefix',
                'Body signature'
            ],
            [
                'sender@test.fr',
                '',
                'Body signature'
            ],
            [
                'sender@test.fr',
                'Subject prefix',
                ''
            ],
            [
                '',
                '',
                ''
            ]
        ];
    }
}
