<?php

namespace App\Command;

use App\Service\SmartInvite\Organizer\FetchReplies;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SmartInviteHandlerTestCommand extends Command
{
    protected static $defaultName = 'app:smart-invite-handle-test';

    /**
     * @var FetchReplies
     */
    private $fetchReplies;

    public function __construct(
        FetchReplies $fetchReplies,
        ?string $name = null
    ) {
        parent::__construct($name);
        $this->fetchReplies = $fetchReplies;
    }

    protected function configure()
    {
        parent::configure(); // TODO: Change the autogenerated stub
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->fetchReplies->handle();
    }
}