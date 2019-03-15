<?php

namespace App\Command;

use App\Entity\SmartInvite\SmartInviteRecipient;
use App\Entity\SmartInvite\SmartInviteReply;
use App\Infrastructure\Imap\ImapClient;
use App\Infrastructure\Imap\IncomingMessage;
use App\Entity\Email\IncomingEmailAttachment;
use App\Entity\Email\IncomingEmail;
use App\Repository\AccountUserRepository;
use App\Repository\Email\AttachmentRepository;
use App\Repository\Email\IncomingEmailRepository;
use App\Repository\SmartInvite\SmartInviteReplyRepository;
use App\Repository\SmartInvite\SmartInviteRepository;
use SSilence\ImapClient\ImapClientException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Sabre\VObject\Reader;

class SmartInviteHandlerTestCommand extends Command
{
    protected static $defaultName = 'app:smart-invite-handle-test';
    private $smartInviteRepository;
    private $accountUserRepository;
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

    public function __construct(
        SmartInviteRepository $smartInviteRepository,
        AccountUserRepository $accountUserRepository,
        IncomingEmailRepository $incomingEmailRepository,
        AttachmentRepository $attachmentRepository,
        SmartInviteReplyRepository $smartInviteReplyRepository,
        ?string $name = null
    ) {
        parent::__construct($name);
        $this->smartInviteRepository = $smartInviteRepository;
        $this->accountUserRepository = $accountUserRepository;
        $this->incomingEmailRepository = $incomingEmailRepository;
        $this->attachmentRepository = $attachmentRepository;
        $this->smartInviteReplyRepository = $smartInviteReplyRepository;
    }

    protected function configure()
    {
        parent::configure(); // TODO: Change the autogenerated stub
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mailbox = 'outlook.office365.com';
        $username = 'test1@buzilatestcompany.onmicrosoft.com';
        $password = 'Bag94547';
        $encryption = ImapClient::ENCRYPT_SSL; // TLS OR NULL accepted

        try {
            $imap = new ImapClient($mailbox, $username, $password, $encryption);
            // You can also check out example-connect.php for more connection options

        } catch (ImapClientException $error){
            echo $error->getMessage().PHP_EOL; // You know the rule, no errors in production ...
            die(); // Oh no :( we failed
        }

        $overallMessages = $imap->countMessages();
        dump($overallMessages);

        $unreadMessages = $imap->countUnreadMessages();
        dump($unreadMessages);

        // Fetch all the messages in the current folder
        $incomingImapEmails = $imap->getMessages();
//        dump($emails);

        /** @var IncomingMessage $emailToDelete */
//        $emailToDelete = $emails[0];
//        dump($emailToDelete->getID());
//
//        $ret = $imap->deleteMessage($emailToDelete->getID());
//        dump($ret);
//
//        $ret = $imap->purge();
//        dump($ret);

        /** @var IncomingMessage $incomingImapEmail */

        foreach ($incomingImapEmails as $incomingImapEmail) {
//            dump($incomingImapEmail);

            $incomingEmail = (new IncomingEmail)
                ->setSubject($incomingImapEmail->header->subject)
                ->setEmailFrom($incomingImapEmail->header->from)
                ->setEmailTo($incomingImapEmail->header->to)
                ->setEmailDate(new \DateTime($incomingImapEmail->header->date))
                ->setMessageId($incomingImapEmail->header->message_id)
                ->setBodyText($incomingImapEmail->message->text)
                ->setBodyHtml($incomingImapEmail->message->html)
            ;
            $this->incomingEmailRepository->persistAndFlush($incomingEmail);

            // file attachments
            foreach ($incomingImapEmail->attachments as $imapAttachment) {
                $attachment = (new IncomingEmailAttachment)
                    ->setName($imapAttachment->name)
                    ->setBody($imapAttachment->body)
                    ->setIncomingEmail($incomingEmail);
                ;
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
                ;
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
                    // log
                    continue;
                }

                $smartInviteReply = (new SmartInviteReply)
                    ->setEmail(strtolower(str_ireplace('mailto:', '', $attendee)))
                    ->setStatus(SmartInviteRecipient::determineStatus($status))
                    ->setSmartInvite($smartInvite)
                    ->setAccountUser($smartInvite->getAccountUser())
                ;
                $this->smartInviteRepository->persistAndFlush($smartInviteReply);

                // save reply
                // if callback url is set then call it

                dump($uid);
                dump($attendee);
                dump($status);
                dump($method);
                dump('');
            }

            $imap->deleteMessage($incomingImapEmail->getID());
        }

//        $ret = $imap->purge();
    }
}