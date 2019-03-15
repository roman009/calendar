<?php

namespace App\Service\SmartInvite\Create;

use App\Entity\AccountUser;
use App\Entity\SmartInvite\SmartInvite;
use App\Entity\SmartInvite\SmartInviteAttachment;
use App\Entity\SmartInvite\SmartInviteEvent;
use App\Entity\SmartInvite\SmartInviteOrganizer;
use App\Entity\SmartInvite\SmartInviteRecipient;
use App\Repository\SmartInvite\SmartInviteAttachmentRepository;
use App\Repository\SmartInvite\SmartInviteEventRepository;
use App\Repository\SmartInvite\SmartInviteOrganizerRepository;
use App\Repository\SmartInvite\SmartInviteRecipientRepository;
use App\Repository\SmartInvite\SmartInviteRepository;
use App\Service\SmartInvite\Organizer\DefaultOrganizer;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Property\Event\Attendees;

class Create
{
    /**
     * @var DefaultOrganizer
     */
    private $defaultOrganizer;
    /**
     * @var SmartInviteRepository
     */
    private $smartInviteRepository;
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

    public function __construct(
        DefaultOrganizer $defaultOrganizer,
        SmartInviteRepository $smartInviteRepository,
        SmartInviteRecipientRepository $recipientRepository,
        SmartInviteOrganizerRepository $organizerRepository,
        SmartInviteEventRepository $eventRepository,
        SmartInviteAttachmentRepository $attachmentRepository
    ) {
        $this->defaultOrganizer = $defaultOrganizer;
        $this->smartInviteRepository = $smartInviteRepository;
        $this->recipientRepository = $recipientRepository;
        $this->organizerRepository = $organizerRepository;
        $this->eventRepository = $eventRepository;
        $this->attachmentRepository = $attachmentRepository;
    }

    public function handle(
        AccountUser $accountUser,
        string $smartInviteId,
        ?string $callbackUrl,
        string $organizerName,
        string $recipientEmail,
        ?string $recipientName,
        string $eventSummary,
        \DateTime $start,
        \DateTime $end,
        string $timezone,
        ?string $location,
        ?string $description
    ): SmartInvite {
        $smartInvite = (new SmartInvite)
            ->setSmartInviteId($smartInviteId)
            ->setCallbackUrl($callbackUrl)
            ->setAccountUser($accountUser);
        $this->smartInviteRepository->persistAndFlush($smartInvite);

        $smartInvite
            ->setOrganizer(
                (new SmartInviteOrganizer)
                    ->setName($organizerName)
                    ->setAccountUser($accountUser)
                    ->setEmail($this->defaultOrganizer->getEmail())
            )
            ->setRecipient(
                (new SmartInviteRecipient)
                    ->setEmail($recipientEmail)
                    ->setAccountUser($accountUser)
                    ->setName($recipientName)
            )
            ->setEvent(
                (new SmartInviteEvent)
                    ->setSummary($eventSummary)
                    ->setStart(new \DateTime($start->format(DATE_ATOM), new \DateTimeZone($timezone)))
                    ->setEnd(new \DateTime($end->format(DATE_ATOM), new \DateTimeZone($timezone)))
                    ->setLocation($location)
                    ->setTimezone($timezone)
                    ->setAccountUser($accountUser)
                    ->setDescription($description)
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

        $voganizer = new \Eluceo\iCal\Property\Event\Organizer('MAILTO:' . $organizer->getEmail(), [
            'CN' => $organizer->getName()
        ]);

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
            ->setDtStamp($event->getCreated());
        $vcalendar->addComponent($vevent);
        $vcalendar->setMethod('REQUEST');
        $vcalendar->setCalendarScale('GREGORIAN');

        $vcalendarRender = $vcalendar->render();

        $attachment = (new SmartInviteAttachment)
            ->setSmartInvite($smartInvite)
            ->setAccountUser($accountUser)
            ->setIcalendar($vcalendarRender);
        $smartInvite->addAttachment($attachment);

        $this->attachmentRepository->persistAndFlush($attachment);

        return $smartInvite;
    }
}
