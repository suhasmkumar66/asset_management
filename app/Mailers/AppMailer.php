<?php
namespace App\Mailers;

use App\Models\Ticket;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer {
	protected $mailer;           

	/**
	 * from email address
	 * @var string
	 */
	protected $fromAddress = 'it@pujanpujari.com';

	/**
	 * from name
	 * @var string
	 */
	protected $fromName = 'Support Ticket';

	/**
	 * email to send to
	 * @var [type]
	 */
	protected $to;

	/**
	 * Subject of the email
	 * @var [type]
	 */
	protected $subject;

	/**
	 * view template for email
	 * @var [type]
	 */
	protected $view;

	/**
	 * data to be sent alone email
	 * @var array
	 */
	protected $data = [];


	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}
	
	/**
	 * Send Ticket information to user
	 * 
	
	 */
	public function sendTicketInformation(Ticket $ticket)
	{
	    var_dump($ticket);
	    die();
		$this->to = "suhasmkumar66@";
		$this->subject = "[Ticket ID: $ticket->ticket_id] $ticket->name";
		$this->view = 'emails.ticket_info';
		$this->data = compact('ticket');

		return $this->deliver();
	}

	/**
	 * Send Ticket Comments/Replies to Ticket Owner
	 *
	 * @param  User   $ticketOwner
	 * @param  User   $user
	 * @param  Ticket  $ticket
	 * @param  Comment  $comment
	 * @return method deliver()
	 */
	

	/**
	 * Send ticket status notification
	 * 
	 * @param  User   $ticketOwner
	 * @param  Ticket  $ticket
	 * @return method deliver()
	 */

	/**
	 * Do the actual sending of the mail
	 */
	public function deliver()
	{
		$this->mailer->send($this->view, $this->data, function($message) {
			$message->from("it@pujanpujari.com", "Dalvkot IT Team")
					->to("suhasmkumar66@")->subject($this->subject);
		});
	}
}