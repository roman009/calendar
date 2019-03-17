<?php

namespace App\Controller\Account;

use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Repository\SmartInvite\SmartInviteRepository;
use App\Service\Account\CalendarServiceProviderIntegrations;
use App\Service\Security\GenerateToken;
use App\Service\SmartInvite\Create\Create;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="account.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class SmartInviteController extends AbstractAccountController
{
    /**
     * @Route("/smart-invite/create/{objectId}", name="account-create-smart-invite")
     *
     * @param Request $request
     * @param string $objectId
     * @param AccountRepository $accountRepository
     * @param AccountUserRepository $accountUserRepository
     * @param Create $create
     * @param \Swift_Mailer $mailer
     *
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function create(
        Request $request,
        string $objectId,
        AccountRepository $accountRepository,
        AccountUserRepository $accountUserRepository,
        Create $create,
        \Swift_Mailer $mailer
    ) {
        $account = $this->authenticate($request, $accountRepository);
        $accountUser = $accountUserRepository->findOneBy(['account' => $account, 'objectId' => $objectId]);

        $form = $this->createFormBuilder()
            ->add('smartInviteId', TextType::class, ['data' => (new GenerateToken)(64)])
            ->add('callbackUrl', TextType::class, ['data' => 'https://enwvy220zidp.x.pipedream.net'])
            ->add('organizerName', TextType::class, ['data' => 'Valeriu the Organizer'])
            ->add('recipientEmail', TextType::class, ['data' => 'valeriu@buzilatestcompany.onmicrosoft.com'])
            ->add('recipientName', TextType::class, ['data' => 'Gigi Kent'])
            ->add('eventSummary', TextType::class, ['data' => 'this is another event summary'])
            ->add('start', TextType::class, ['data' => (new \DateTime('+25 hours'))->format(DATE_ATOM)])
            ->add('end', TextType::class, ['data' => (new \DateTime('+25 hours 20 minutes'))->format(DATE_ATOM)])
            ->add('timezone', TextType::class, ['data' => 'CET'])
            ->add('location', TextType::class, ['data' => '69th floor'])
            ->add('description', TextType::class, ['data' => 'some cool event description'])
            ->add('create', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $smartInvite = $create->handle(
                $accountUser,
                $form->getData()['smartInviteId'],
                $form->getData()['callbackUrl'],
                $form->getData()['organizerName'],
                $form->getData()['recipientEmail'],
                $form->getData()['recipientName'],
                $form->getData()['eventSummary'],
                new \DateTime($form->getData()['start']),
                new \DateTime($form->getData()['end']),
                $form->getData()['timezone'],
                $form->getData()['location'],
                $form->getData()['description']
            );


            $messageAttachment = new \Swift_Attachment($smartInvite->getAttachments()[0]->getIcalendar(), 'cal.ics', 'text/calendar');
            $message = (new \Swift_Message('This is a smart invite with ID ' . $form->getData()['smartInviteId']))
//            ->setFrom('postmaster@sandboxf05b190d1444418fb0b4407bfe487b16.mailgun.org')
                ->setFrom('test2@buzilatestcompany.onmicrosoft.com')
                ->setTo($smartInvite->getRecipient()->getEmail())
                ->setBody('see attached calendar invite', 'text/html')
                ->addPart('see attached calendar invite', 'text/plain')
                ->attach($messageAttachment);

            $messagePart = new \Swift_MimePart($smartInvite->getAttachments()[0]->getIcalendar(), 'text/calendar; method=REQUEST', 'UTF-8');
            $messagePart->setEncoder(new \Swift_Mime_ContentEncoder_PlainContentEncoder('7bit'));

            $message->attach($messagePart);

            $mailer->send($message);

            return $this->redirectToRoute('account-view-smart-invite', ['objectId' => $objectId]);
        }

        return $this->render('Account/create_smart_invite.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/smart-invite/view/{objectId}", name="account-view-smart-invite")
     *
     * @param Request $request
     * @param string $providerName
     * @param string $objectId
     * @param string $tokenObjectId
     * @param AccountRepository $accountRepository
     * @param AccountUserRepository $accountUserRepository
     * @param CalendarServiceProviderIntegrations $calendarServiceProviderIntegrations
     *
     * @throws \Exception
     */
    public function view(
        Request $request,
        string $objectId,
        AccountRepository $accountRepository,
        AccountUserRepository $accountUserRepository,
        SmartInviteRepository $smartInviteRepository
    ) {
        $account = $this->authenticate($request, $accountRepository);
        $accountUser = $accountUserRepository->findOneBy(['account' => $account, 'objectId' => $objectId]);

        $smartInvites = $smartInviteRepository->findBy(['accountUser' => $accountUser]);

        return $this->render('Account/view_smart_invite.html.twig', ['smart_invites' => $smartInvites]);
    }
}
