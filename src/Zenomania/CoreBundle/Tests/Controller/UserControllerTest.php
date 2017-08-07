<?php

namespace Zenomania\CoreBundle\Tests\Controller;

use org\bovigo\vfs\vfsStream;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Form;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\UserRole;
use Zenomania\CoreBundle\Entity\UserStatus;

class UserControllerTest extends ControllerTestCase
{
    /**
     * Test if avatar paths in users table are prefixed with /uploads/profiles after User update
     */
    public function testAvatarSave()
    {
        $user = $this->getTestUser();
        /** @var Crawler $crawler */
        $crawler = $this->getClient()->request('GET', sprintf('/user/%d/edit', $user->getId()));
        /** @var Form $form */
        $form = $crawler->selectButton('Сохранить')->form();
        $form['user[avatar]']->upload($this->getAvatarPath());
        // remove nested delete form
        $form->remove('form');
        $form->remove('_method');
        $this->getClient()->submit($form);
        $avatarDirectory = '/uploads/profiles';
        // User gets detached upon form submit and is not synchronized at this point
        $user = $this->getUserFromRepository($user->getId());

        $this->assertTrue(strpos($user->getAvatar(), $avatarDirectory)!==false);
        $this->assertTrue(strpos($user->getAvatarSmall(), $avatarDirectory)!==false);
//      $this->assertStringStartsWith($avatarDirectory, $user->getAvatar());
//      $this->assertStringStartsWith($avatarDirectory, $user->getAvatarSmall());
    }

    /**
     * Test if index page loaded successfully
     */
    public function testIndex()
    {
        /** @var Crawler $crawler */
        $crawler = $this->getClient()->request('GET', '/user/');
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('table')->count());
    }

    /**
     * Test if index page loaded successfully
     */
    public function testShow()
    {
        /** @var Crawler $crawler */
        $crawler = $this->getClient()->request('GET', sprintf('/user/%d/show', $this->getTestUser()->getId()));
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('table')->count());
    }

    /**
     * Test if there is error after empty new user form submission
     */
    public function testNewBlankFieldsError()
    {
        /** @var Crawler $crawler */
        $crawler = $this->getClient()->request('GET', '/user/new');
        /** @var Form $form */
        $form = $crawler->selectButton('Сохранить')->form();
        $form['user[status]']->disableValidation()->select('');
        $form['user[role]']->disableValidation()->select('');
        $crawler = $this->getClient()->submit($form, []);
        $this->assertContains('This value should not be blank', $crawler->text());
        $this->assertFalse($this->getClient()->getResponse()->isRedirection());
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
    }

    /**
     * Test if there is error after empty new user form submission
     */
    public function testEditBlankFieldsError()
    {
        /** @var Crawler $crawler */
        $crawler = $this->getClient()->request('GET', sprintf('/user/%d/edit', $this->getTestUser()->getId()));
        /** @var Form $form */
        $form = $crawler->selectButton('Сохранить')->form();
        $form->setValues(
            [
                'user[firstname]' => '',
                'user[lastname]' => '',
                'user[login]' => '',
                'user[password]' => '',
                'user[birthDate]' => '',
                'user[phone]' => '',
            ]
        );
        $form['user[status]']->disableValidation()->select('');
        $form['user[role]']->disableValidation()->select('');
        // remove nested delete form
        $form->remove('form');
        $form->remove('_method');
        $crawler = $this->getClient()->submit($form, []);
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
        $this->assertContains('This value should not be blank', $crawler->text());
        $this->assertFalse($this->getClient()->getResponse()->isRedirection());
    }

    /**
     * Test if valid edit form submission is successful
     */
    public function testEdit()
    {
        /** @var Crawler $crawler */
        $crawler = $this->getClient()->request('GET', sprintf('/user/%d/edit', $this->getTestUser()->getId()));
        /** @var Form $form */
        $form = $crawler->selectButton('Сохранить')->form();
        // remove nested delete form
        $form->remove('form');
        $form->remove('_method');
        $this->getClient()->submit($form);
        $this->assertTrue($this->getClient()->getResponse()->isRedirection());
    }

    /**
     * Test if valid new form submission is successful
     */
    public function testNew()
    {
        /** @var Crawler $crawler */
        $crawler = $this->getClient()->request('GET', sprintf('/user/new', $this->getTestUser()->getId()));
        /** @var Form $form */
        $form = $crawler->selectButton('Сохранить')->form();
        $form->setValues(
            [
                'user[firstname]' => Uuid::uuid4(),
                'user[lastname]' => Uuid::uuid4(),
                'user[login]' => Uuid::uuid4(),
                'user[password]' => Uuid::uuid4(),
                'user[birthDate]' => (new \DateTime())->format('d.m.Y'),
                'user[phone]' => $this->getRandomPhoneNumber(),
            ]
        );
        $this->getClient()->submit($form);
        $this->assertTrue($this->getClient()->getResponse()->isRedirection());
        $this->assertRegExp('#/user/\d+/show#', $this->getClient()->getResponse()->headers->get('Location'));
    }

    private function getRandomPhoneNumber()
    {
        return '7' . implode(
            array_map(
                function () {
                    return rand(0, 9);
                },
                range(0, 9)
            )
        );
    }

    /**
     * @param $id
     * @return User|null
     */
    private function getUserFromRepository($id)
    {
        return $this->getEntityManager()
            ->getRepository(User::class)
            ->find($id);
    }

    /**
     * @return User
     */
    private function getTestUser()
    {
        $entityManager = $this->getEntityManager();
        $userStatus = $entityManager->getRepository('ZenomaniaCoreBundle:UserStatus')
            ->findOneBy(['code' => UserStatus::STATUS_ACTIVE]);
        $userRole = $entityManager->getRepository('ZenomaniaCoreBundle:UserRole')
            ->findOneBy(['name' => UserRole::ROLE_USER]);
        $user = new User();
        $user->setStatus($userStatus);
        $user->setRole($userRole);
        $user->setFirstname($this->getRandomString(15));
        $user->setLastname($this->getRandomString(15));
        $user->setLogin($this->getRandomString(15));
        $user->setEmail($this->getRandomString(15) . '@' . $this->getRandomString(5) . '.ru');
        $user->setPhone($this->getRandomPhoneNumber());
        $this->getContainer()->get('user.service')->save($user);
        $this->user = $user;

        return $user;
    }

    private function getRandomString($length, $keyspace = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    private function getAvatarPath()
    {
        vfsStream::setup('avatar');
        $filename = vfsStream::url('avatar/avatar.png');
        /** @var resource $image */
        $image = imagecreate(200, 200);
        /** @var int $red */
        $red = imagecolorallocate($image, 255, 0, 0);
        imagefill($image, 0, 0, $red);
        ob_start();
        imagepng($image);
        file_put_contents($filename, ob_get_contents());
        ob_end_clean();

        return $filename;
    }
}
