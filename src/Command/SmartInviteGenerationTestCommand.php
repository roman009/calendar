<?php

namespace App\Command;

use App\Entity\SmartInvite\SmartInviteAttachment;
use App\Entity\SmartInvite\SmartInviteEvent;
use App\Entity\SmartInvite\SmartInviteOrganizer;
use App\Entity\SmartInvite\SmartInviteRecipient;
use App\Entity\SmartInvite\SmartInvite;
use App\Repository\AccountUserRepository;
use App\Repository\SmartInvite\SmartInviteAttachmentRepository;
use App\Repository\SmartInvite\SmartInviteEventRepository;
use App\Repository\SmartInvite\SmartInviteOrganizerRepository;
use App\Repository\SmartInvite\SmartInviteRecipientRepository;
use App\Repository\SmartInvite\SmartInviteRepository;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Property\Event\Attendees;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SmartInviteGenerationTestCommand extends Command
{
    protected static $defaultName = 'app:smart-invite-send-test';
    /**
     * @var SmartInviteRepository
     */
    private $smartInviteRepository;
    /**
     * @var AccountUserRepository
     */
    private $accountUserRepository;
    /**
     * @var SmartInviteRecipientRepository
     */
    private $recipientRepository;
    /**
     * @var SmartInviteOrganizerRepository
     */
    private $organizerRepository;
    /**
     * @var SmartInviteEventRepository
     */
    private $eventRepository;
    /**
     * @var SmartInviteAttachmentRepository
     */
    private $attachmentRepository;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(
        SmartInviteRepository $smartInviteRepository,
        AccountUserRepository $accountUserRepository,
        SmartInviteRecipientRepository $recipientRepository,
        SmartInviteOrganizerRepository $organizerRepository,
        SmartInviteEventRepository $eventRepository,
        SmartInviteAttachmentRepository $attachmentRepository,
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

        $timezone = 'CET';
        $smartInvite
            ->setOrganizer((new SmartInviteOrganizer)
                ->setName('The actual organizer')
                ->setAccountUser($accoutUser)
                ->setEmail('test1@buzilatestcompany.onmicrosoft.com')
            )
            ->setRecipient((new SmartInviteRecipient)
//                ->setEmail('valeriu@buzilatestcompany.onmicrosoft.com')
                ->setEmail('valeriu.buzila@gmail.com')
                ->setAccountUser($accoutUser)
                ->setName('Gigel')
            )
            ->setEvent(
                (new SmartInviteEvent)
                ->setSummary('this is the event summary')
                ->setStart(new \DateTime('2019-03-28 11:00', new \DateTimeZone($timezone)))
                ->setEnd(new \DateTime('2019-03-28 13:00', new \DateTimeZone($timezone)))
                ->setLocation('1st floor')
                ->setTimezone($timezone)
                ->setAccountUser($accoutUser)
                ->setDescription('this is the event description')
            );

        $organizer = $smartInvite->getOrganizer();
//        $organizer->setEmail($smartInvite->getObjectId() . '+' . $organizer->getEmail());
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
            'CN' => $recipient->getName(),
        ]);
        $vattendees->add('MAILTO:' . $organizer->getEmail(), [
            'CUTYPE' => 'INDIVIDUAL',
            'ROLE' => 'REQ-PARTICIPANT',
            'PARTSTAT' => 'ACCEPTED',
            'X-NUM-GUESTS' => '0',
            'RSVP' => 'TRUE',
            'CN' => $organizer->getName(),
        ]);
//        $voganizer = new \Eluceo\iCal\Property\Event\Organizer('organizer@calendar.lan', [
//        $voganizer = new \Eluceo\iCal\Property\Event\Organizer('MAILTO:' . 'valeriu@buzilatestcompany.onmicrosoft.com', [
        $voganizer = new \Eluceo\iCal\Property\Event\Organizer('MAILTO:' . $organizer->getEmail(), [
            'CN' => $organizer->getName()
        ]);
//        $vevent = new \Eluceo\iCal\Component\Event($smartInvite->getObjectId() . '+invite@calendar.lan');
        $vevent = new \Eluceo\iCal\Component\Event($smartInvite->getObjectId() . '+' . $organizer->getEmail());
        $vevent
            ->setSummary($event->getSummary())
            ->setDtStart($event->getStart())
            ->setDtEnd($event->getEnd())
            ->setOrganizer($voganizer)
            ->setAttendees($vattendees)
            ->setLocation($event->getLocation())
            ->setStatus(\Eluceo\iCal\Component\Event::STATUS_CONFIRMED)
            ->setTimezoneString((new \DateTimeZone($timezone))->getName())
            ->setDescription($event->getDescription())
            ->setCreated($event->getCreated())
            ->setDtStamp($event->getCreated())
        ;
        $vcalendar->addComponent($vevent);
//        $vcalendar->setTimezone($smartInvite->getEvent()->getTimezone());
        $vcalendar->setMethod('REQUEST');
        $vcalendar->setCalendarScale('GREGORIAN');

        dump($smartInvite);

        $vcalendarRender = $vcalendar->render();
        dump($vcalendarRender);

        $attachment = (new SmartInviteAttachment)
            ->setSmartInvite($smartInvite)
            ->setAccountUser($accoutUser)
            ->setIcalendar($vcalendar->render());

        $this->attachmentRepository->persistAndFlush($attachment);

        $messageAttachment = new \Swift_Attachment($vcalendarRender, 'cal.ics', 'text/calendar');
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom($smtpPostmaster)
            ->setTo($recipient->getEmail())
            ->setBody('see attached calendarinvite', 'text/html')
            ->addPart('see attached calendar invite', 'text/plain')
            ->attach($messageAttachment)
        ;

        $messagePart = new \Swift_MimePart($vcalendarRender, 'text/calendar; method=REQUEST', 'UTF-8');
        $messagePart->setEncoder(new \Swift_Mime_ContentEncoder_PlainContentEncoder('7bit'));

        $message->attach($messagePart);

        $this->mailer->send($message);
    }
}
