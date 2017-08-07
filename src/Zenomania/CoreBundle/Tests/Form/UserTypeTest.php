<?php

namespace Zenomania\CoreBundle\Tests\Form;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\FormFactory;
use Zenomania\CoreBundle\Form\UserType;

class UserTypeTest extends WebTestCase
{
    /** @var  FormFactory */
    private $formFactory;

    protected function setUp()
    {
        static::bootKernel();
        /** @var Container $container */
        $container = static::$kernel->getContainer();
        $this->formFactory = $container->get('form.factory');
    }

    public function testBlankErrors()
    {
        $requiredFields = [
            'firstname',
            'lastname',
            'login',
            'password',
            'phone',
            'status',
            'role'
        ];
        $form = $this->getForm(
            UserType::class,
            null,
            ['validation_groups' => ['registration', 'Default']]
        );
        $form->submit(null);
        $this->assertFalse($form->isValid());
        foreach ($requiredFields as $requiredFieldName) {
            $field = $form->get($requiredFieldName);
            $this->assertGreaterThan(0, count($field->getErrors()), "Field '$requiredFieldName' must have blank error");
        }
    }

    /**
     * @param $type
     * @param mixed $data
     * @param array|null $options
     * @return \Symfony\Component\Form\FormInterface
     */
    private function getForm($type, $data = null, array $options = [])
    {
        return $this->formFactory->create(
            $type,
            $data,
            array_merge($options, ['csrf_protection' => false])
        );
    }
}
