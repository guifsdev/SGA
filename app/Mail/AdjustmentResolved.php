<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdjustmentResolved extends Mailable
{
    use Queueable, SerializesModels;

    public $adjustments;
    public $studentName;
	public $result;
	public $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($studentName, $adjustments, $result, $reason)
    {
        $this->studentName = ucfirst(strtolower($studentName));
        $this->adjustments = $adjustments;
		$this->result = $result;
		$this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Resultado do ajuste')
            ->replyTo('sga@vm.uff.br')
			->bcc('sga.aplicacoes@gmail.com')
            ->markdown('mail/adjustment-resolved');
    }
}
