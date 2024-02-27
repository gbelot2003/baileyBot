<?php

namespace App\Conversation;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class OnbordingConversation extends Conversation
{
    protected $firstname;

    protected $email;

    public function Welcome()
    {
        return $this->ask('Hello! What is your firstname?', function(Answer $answer) {
            // Save result
            \Log::info($answer);
            $this->firstname = $answer->getText();

            $this->say('Nice to meet you '.$this->firstname);
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('One more thing - what is your email?', function(Answer $answer) {
            // Save result
            $this->email = $answer->getText();

            $this->say('Great - that is all we need, '.$this->firstname);
        });
    }

    public function run()
    {
        $this->Welcome();
    }
}
