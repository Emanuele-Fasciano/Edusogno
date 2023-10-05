<?php

// creo una classe Event
class Event
{
    public $title;
    public $attendees;
    public $description;
    public $date;

    public function __construct($title, $attendees, $description, $date)
    {
        $this->title = $title;
        $this->attendees = $attendees;
        $this->description = $description;
        $this->date = $date;
    }
}
