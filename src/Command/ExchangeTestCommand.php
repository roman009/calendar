<?php

namespace App\Command;

use App\Entity\Calendar\CalendarServiceProvider;
use App\Repository\AccountUserRepository;
use App\Repository\UserRepository;
use App\Service\Calendar\Connector\Connector;
use App\Service\Calendar\Fetch\Fetch;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExchangeTestCommand extends Command
{
    protected static $defaultName = 'app:exchange-test';
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var Connector
     */
    private $connector;
    /**
     * @var Fetch
     */
    private $fetch;
    /**
     * @var AccountUserRepository
     */
    private $accountUserRepository;

    public function __construct(UserRepository $userRepository, AccountUserRepository $accountUserRepository, Connector $connector, Fetch $fetch, ?string $name = null)
    {
        parent::__construct($name);
        $this->userRepository = $userRepository;
        $this->connector = $connector;
        $this->fetch = $fetch;
        $this->accountUserRepository = $accountUserRepository;
    }

    protected function configure()
    {
        parent::configure(); // TODO: Change the autogenerated stub
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userRepository->findOneBy(['email' => 'valeriu.buzila@gmail.com']);
        $accountUser = $this->accountUserRepository->findOneBy(['user' => $user]);

        $service = CalendarServiceProvider::get('exchange');
        dump($service);

        if (!$this->connector->isRegistered($accountUser, $service)) {
            dump('register');
//            $username = 'test1@buzilatestcompany.onmicrosoft.com';
//            $password = 'Bag94547';
//            $this->connector->register($accountUser, $service, $username, $password);
        } else {
            dump('not valid');
        }

        $token = $this->connector->getToken($accountUser, $service);

        dump($token);

        $calendars = $this->fetch->calendars($service, $token);
        dump($calendars);

//        $freeBusy = $this->fetch->freeBusy($service, $token, new \DateTime(), (new \DateTime())->add(\DateInterval::createFromDateString('+20 days')), $calendars);
//        dump($freeBusy);

        $events = $this->fetch->events(
            $service,
            $token,
            new \DateTime(),
            (new \DateTime())->add(\DateInterval::createFromDateString('+20 days')),
            $calendars[0]->getObjectId()
        );

        dump($events);
    }
}
