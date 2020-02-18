<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdjustmentSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $adjustments;
    public $studentName;
	public $signature;



    public function __construct($studentName, $adjustments, $signature)
    {
        $this->studentName = ucfirst(strtolower($studentName));
        $this->adjustments = $adjustments;
		$this->signature = $signature;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Ajuste de Disciplinas')
            ->replyTo('sga@vm.uff.br')
            ->markdown('mail/adjustment-sent');
    }
}
