<?php

namespace App\Command;

use App\Entity\SmartInvite\Attachment;
use App\Entity\SmartInvite\Event;
use App\Entity\SmartInvite\Organizer;
use App\Entity\SmartInvite\Recipient;
use App\Entity\SmartInvite\SmartInvite;
use App\Repository\AccountUserRepository;
use App\Repository\SmartInvite\AttachmentRepository;
use App\Repository\SmartInvite\EventRepository;
use App\Repository\SmartInvite\OrganizerRepository;
use App\Repository\SmartInvite\RecipientRepository;
use App\Repository\SmartInvite\SmartInviteRepository;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Property\Event\Attendees;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SmartInviteTestCommand extends Command
{
    protected static $defaultName = 'app:smart-invite-test';
    /**
     * @var SmartInviteRepository
     */
    private $smartInviteRepository;
    /**
     * @var AccountUserRepository
     */
    private $accountUserRepository;
    /**
     * @var RecipientRepository
     */
    private $recipientRepository;
    /**
     * @var OrganizerRepository
     */
    private $organizerRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var AttachmentRepository
     */
    private $attachmentRepository;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(
        SmartInviteRepository $smartInviteRepository,
        AccountUserRepository $accountUserRepository,
        RecipientRepository $recipientRepository,
        OrganizerRepository $organizerRepository,
        EventRepository $eventRepository,
        AttachmentRepository $attachmentRepository,
        \Swift_Mailer $mailer,
        ?string $name = null
    ) {
        parent::__construct($name);
        $this->smartInviteRepository = $smartInviteRepository;
        $this->accountUserRepository = $accountUserRepository;
        $this->recipientRepository = $recipientRepository;
        $this->organizerRepository = $organizerRepository;
        $this->eventRepository = $eventRepository;
        $this->attachmentRepository = $attachmentRepository;
        $this->mailer = $mailer;
    }

    protected function configure()
    {
        parent::configure(); // TODO: Change the autogenerated stub
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $accoutUser = $this->accountUserRepository->find(1);
        $smtpPostmaster = 'postmaster@sandboxf05b190d1444418fb0b4407bfe487b16.mailgun.org';

        $smartInvite = (new SmartInvite)
            ->setSmartInviteId('some-invite-iddd')
            ->setCallbackUrl('https://postb.in/XEkkZ1Sv')
            ->setAccountUser($accoutUser);
        $this->smartInviteRepository->persistAndFlush($smartInvite);

        $smartInvite
            ->setOrganizer((new Organizer)->setName('some organizer name')->setAccountUser($accoutUser))
            ->setRecipient((new Recipient)->setEmail('valeriu@buzila.ro')->setAccountUser($accoutUser))
            ->setEvent(
                (new Event)
                ->setSummary('this is the event summary')
                ->setStart(new \DateTime('2019-03-28 11:00', new \DateTimeZone('CET')))
                ->setEnd(new \DateTime('2019-03-28 13:00', new \DateTimeZone('CET')))
                ->setLocation('1st floor')
                ->setTimezone('CET')
                ->setAccountUser($accoutUser)
            );

        $organizer = $smartInvite->getOrganizer();
        $organizer->setSmartInvite($smartInvite);

        $recipient = $smartInvite->getRecipient();
        $recipient->setSmartInvite($smartInvite);

        $event = $smartInvite->getEvent();
        $event->setSmartInvite($smartInvite);

        $this->recipientRepository->persistAndFlush($recipient);
        $this->organizerRepository->persistAndFlush($organizer);
        $this->eventRepository->persistAndFlush($event);

        $this->smartInviteRepository->persistAndFlush($smartInvite);

        $vcalendar = new Calendar('//Calendar//Calendar.lan 0.1//EN');
        $vattendees = new Attendees();
        $vattendees->add('MAILTO:' . $recipient->getEmail(), [
            'CUTYPE' => 'INDIVIDUAL',
            'ROLE' => 'REQ-PARTICIPANT',
            'PARTSTAT' => 'NEEDS-ACTION',
            'X-NUM-GUESTS' => '0',
            'RSVP' => 'TRUE',
            'CN' => $recipient->getEmail(),
        ]);
//        $voganizer = new \Eluceo\iCal\Property\Event\Organizer('organizer@calendar.lan', [
        $voganizer = new \Eluceo\iCal\Property\Event\Organizer('MAILTO:' . $smtpPostmaster, [
            'CN' => $organizer->getName()
        ]);
//        $vevent = new \Eluceo\iCal\Component\Event($smartInvite->getObjectId() . '+invite@calendar.lan');
        $vevent = new \Eluceo\iCal\Component\Event($smartInvite->getObjectId() . '+' . $smtpPostmaster);
        $vevent
            ->setSummary($event->getSummary())
            ->setDtStart($event->getStart())
            ->setDtEnd($event->getEnd())
            ->setOrganizer($voganizer)
            ->setAttendees($vattendees)
            ->setLocation($event->getLocation());
        $vcalendar->addComponent($vevent);
        $vcalendar->setTimezone($smartInvite->getEvent()->getTimezone());
        $vcalendar->setMethod('REQUEST');

        dump($smartInvite);

        $vcalendarRender = $vcalendar->render();
        dump($vcalendarRender);

        $attachment = (new Attachment)
            ->setSmartInvite($smartInvite)
            ->setAccountUser($accoutUser)
            ->setIcalendar($vcalendar->render());

        $this->attachmentRepository->persistAndFlush($attachment);

        $messageAttachment = new \Swift_Attachment($vcalendarRender, 'cal.ics', 'text/calendar');
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('postmaster@sandboxf05b190d1444418fb0b4407bfe487b16.mailgun.org')
            ->setTo($recipient->getEmail())
            ->setBody('see attached calendarinvite', 'text/html')
            ->attach($messageAttachment);
        $message->addPart($vcalendarRender, 'text/calendar', 'utf-8');

        $this->mailer->send($message);
    }
}
