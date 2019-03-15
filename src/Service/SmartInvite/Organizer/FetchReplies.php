<?php

namespace App\Service\SmartInvite\Organizer;

use App\Entity\Email\IncomingEmail;
use App\Entity\Email\IncomingEmailAttachment;
use App\Entity\SmartInvite\SmartInviteRecipient;
use App\Entity\SmartInvite\SmartInviteReply;
use App\Infrastructure\Imap\ImapClient;
use App\Infrastructure\Imap\IncomingMessage;
use App\Message\ReplyReceivedNotification;
use App\Repository\Email\AttachmentRepository;
use App\Repository\Email\IncomingEmailRepository;
use App\Repository\SmartInvite\SmartInviteReplyRepository;
use App\Repository\SmartInvite\SmartInviteRepository;
use Psr\Log\LoggerInterface;
use Sabre\VObject\Reader;
use Symfony\Component\Messenger\MessageBusInterface;

class FetchReplies
{
    /**
     * @var SmartInviteRepository
     */
    private $smartInviteRepository;
    /**
     * @var IncomingEmailRepository
     */
    private $incomingEmailRepository;
    /**
     * @var AttachmentRepository
     */
    private $attachmentRepository;
    /**
     * @var SmartInviteReplyRepository
     */
    private $smartInviteReplyRepository;
    /**
     * @var ImapClient
     */
    private $imapClient;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var DefaultOrganizer
     */
    private $defaultOrganizer;
    /**
     * @var MessageBusInterface
     */
    private $bus;

    public function __construct(
        DefaultOrganizer $defaultOrganizer,
        SmartInviteRepository $smartInviteRepository,
        IncomingEmailRepository $incomingEmailRepository,
        AttachmentRepository $attachmentRepository,
        SmartInviteReplyRepository $smartInviteReplyRepository,
        LoggerInterface $logger,
        MessageBusInterface $bus
    ) {
        $this->smartInviteRepository = $smartInviteRepository;
        $this->incomingEmailRepository = $incomingEmailRepository;
        $this->attachmentRepository = $attachmentRepository;
        $this->smartInviteReplyRepository = $smartInviteReplyRepository;
        $this->logger = $logger;
        $this->defaultOrganizer = $defaultOrganizer;
        $this->bus = $bus;
    }

    public function handle()
    {
        $this->imapClient = new ImapClient(
            $this->defaultOrganizer->getMailboxUrl(),
            $this->defaultOrganizer->getMailboxUsername(),
            $this->defaultOrganizer->getMailboxPassword(),
            ImapClient::ENCRYPT_SSL
        );

        // Fetch all the messages in the current folder
        $incomingImapEmails = $this->imapClient->getMessages();

        /** @var IncomingMessage $incomingImapEmail */
        foreach ($incomingImapEmails as $incomingImapEmail) {
            $incomingEmail = (new IncomingEmail)
                ->setSubject($incomingImapEmail->header->subject)
                ->setEmailFrom($incomingImapEmail->header->from)
                ->setEmailTo($incomingImapEmail->header->to)
                ->setEmailDate(new \DateTime($incomingImapEmail->header->date))
                ->setMessageId($incomingImapEmail->header->message_id)
                ->setBodyText($incomingImapEmail->message->text)
                ->setBodyHtml($incomingImapEmail->message->html);
            $this->incomingEmailRepository->persistAndFlush($incomingEmail);

            // file attachments
            foreach ($incomingImapEmail->attachments as $imapAttachment) {
                $attachment = (new IncomingEmailAttachment)
                    ->setName($imapAttachment->name)
                    ->setBody($imapAttachment->body)
                    ->setIncomingEmail($incomingEmail);

                $this->attachmentRepository->persistAndFlush($attachment);
                $incomingEmail->addAttachment($attachment);
            }

            // mime email body contents
            foreach ($incomingImapEmail->message->info as $infoItem) {
                if ($infoItem->structure->subtype !== 'CALENDAR') {
                    continue;
                }
                $attachment = (new IncomingEmailAttachment)
                    ->setName('body_subtype.ics')
                    ->setBody((string)$infoItem)
                    ->setIncomingEmail($incomingEmail);

                $this->attachmentRepository->persistAndFlush($attachment);
                $incomingEmail->addAttachment($attachment);
            }

            /** @var IncomingEmailAttachment $attachment */
            foreach ($incomingEmail->getAttachments() as $attachment) {
                $vcalendar = Reader::read($attachment->getBody());
                $uid = (string)$vcalendar->VEVENT->UID;
                $attendee = (string)$vcalendar->VEVENT->ATTENDEE;
                $status = (string)$vcalendar->VEVENT->ATTENDEE->parameters['PARTSTAT'];
                $method = (string)$vcalendar->METHOD;

                $objectId = explode('+', $uid);

                $smartInvite = $this->smartInviteRepository->findOneBy(['objectId' => $objectId]);
                if (null === $smartInvite) {
                    $this->logger->warning('Unable to find smart invite', [
                        'domain' => get_class($this),
                        'object_id' => $objectId,
                        'incoming_email_id' => $incomingEmail->getId(),
                    ]);
                    continue;
                }

                $smartInviteReply = (new SmartInviteReply)
                    ->setEmail(strtolower(str_ireplace('mailto:', '', $attendee)))
                    ->setStatus(SmartInviteRecipient::determineStatus($status))
                    ->setSmartInvite($smartInvite)
                    ->setAccountUser($smartInvite->getAccountUser());
                $this->smartInviteReplyRepository->persistAndFlush($smartInviteReply);

                $this->bus->dispatch(new ReplyReceivedNotification($smartInviteReply->getId()));
            }

            $this->imapClient->deleteMessage($incomingImapEmail->getID());
        }

//        $ret = $this->imapClient->purge();
    }
}
