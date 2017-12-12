<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 07.12.17
 * Time: 14:44
 */

namespace Zenomania\CoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zenomania\ApiBundle\Service\Utils\PeriodConverter;
use Zenomania\CoreBundle\Entity\Badge;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Exception;

class BadgeRatingCommand extends ContainerAwareCommand
{
    const PERIOD_MONTH = 'month';
    const PERIOD_SEASON = 'season';

    protected function configure()
    {
        $this->setName('badge:rating')
            ->setDescription('Top rating')
            ->addArgument(
                'period',
                InputArgument::REQUIRED,
                'period type(month|season)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $period = $input->getArgument('period');
        if (!in_array($period, [self::PERIOD_MONTH, self::PERIOD_SEASON])) {
            throw new Exception('Не верно задан период');
        }

        $output->writeln("<info>Start find top user</info>");
        $service = $this->getContainer()->get('user_badge.service');

        $periodConverter = new PeriodConverter($period);
        /** @var User $user */
        $user = $service->getTopUser($periodConverter);
        $badgeCode = $this->getBadgeCode($period);

        $service->giveBadgeForRatings($user, $badgeCode, $periodConverter);

        $output->writeln("<info>Top user of " . $period . " - " . $user->__toString() . "</info>");
    }

    protected function getBadgeCode(string $period)
    {
        switch ($period) {
            case self::PERIOD_MONTH:
                return Badge::TYPE_TOP_RATINGS_OF_MONTH;
                break;
            case self::PERIOD_SEASON:
                return Badge::TYPE_TOP_RATINGS_OF_SEASON;
                break;
            default:
                throw new Exception("Бейдж не найден", 404);
        }
    }
}