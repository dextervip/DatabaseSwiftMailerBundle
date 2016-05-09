<?php
/**
 * Created by PhpStorm.
 * User: Rafael
 * Date: 02/05/2015
 * Time: 22:16
 */

namespace Citrax\Bundle\DatabaseSwiftMailerBundle\Spool;


use Citrax\Bundle\DatabaseSwiftMailerBundle\Entity\Email;
use Citrax\Bundle\DatabaseSwiftMailerBundle\Entity\EmailRepository;
use Swift_Mime_Message;
use Swift_Transport;

class DatabaseSpool extends \Swift_ConfigurableSpool {
    /**
     * @var EmailRepository
     */
    private $repository;

    private $parameters;

    public function __construct(EmailRepository $repository, $parameters)
    {
        $this->repository = $repository;
        $this->parameters = $parameters;
    }


    /**
     * Starts this Spool mechanism.
     */
    public function start()
    {
        // TODO: Implement start() method.
    }

    /**
     * Stops this Spool mechanism.
     */
    public function stop()
    {
        // TODO: Implement stop() method.
    }

    /**
     * Tests if this Spool mechanism has started.
     *
     * @return bool
     */
    public function isStarted()
    {
        return true;
    }

    /**
     * Queues a message.
     *
     * @param Swift_Mime_Message $message The message to store
     *
     * @return bool    Whether the operation has succeeded
     */
    public function queueMessage(Swift_Mime_Message $message)
    {
        $email = new Email();
        $email->setFromEmail(implode('; ', array_keys($message->getFrom())) );

        if($message->getTo() !== null ){
            $email->setToEmail(implode('; ', array_keys($message->getTo())) );
        }
        if($message->getCc() !== null ){
            $email->setCcEmail(implode('; ', array_keys($message->getCc())) );
        }
        if($message->getBcc() !== null ){
            $email->setBccEmail(implode('; ', array_keys($message->getBcc())) );
        }
        if($message->getReplyTo() !== null ){
            $email->setReplyToEmail(implode('; ', array_keys($message->getReplyTo())) );
        }

        $email->setBody($message->getBody());
        $email->setSubject($message->getSubject());
        $email->setMessage($message);

        $this->repository->addEmail($email);
    }

    /**
     * Sends messages using the given transport instance.
     *
     * @param Swift_Transport $transport A transport instance
     * @param string[] $failedRecipients An array of failures by-reference
     *
     * @return int     The number of sent emails
     */
    public function flushQueue(Swift_Transport $transport, &$failedRecipients = null)
    {
        if (!$transport->isStarted())
        {
            $transport->start();
        }

        $count = 0;
        $emails = $this->repository->getEmailQueue($this->getMessageLimit());

        foreach($emails as $email){
            /*@var $message \Swift_Mime_Message */
            $message = $email->getMessage();
            try{
                $count_= $transport->send($message, $failedRecipients);
                if($count_ > 0){
                    $this->repository->markCompleteSending($email);
                    $count += $count_;
                }else{
                    throw new \Swift_SwiftException('The email was not sent.');
                }
            }catch(\Swift_SwiftException $ex){
                $this->repository->markFailedSending($email, $ex);
            }
        }

        return $count;
    }
}
