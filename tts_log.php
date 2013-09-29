<?php
class ttsLog {
	public $id = -1;
	public $date = '';
	public $text = '';
	public $sender = '';
	public $ip = '';
	public $location = '';
	
	public function __construct(array $row) {
		$this->id = $row['id'];
		$this->date = $row['date'];
		$this->text = $row['text'];
		$this->sender = $row['sender'];
		$this->ip = $row['ip'];
		$this->location = $row['location'];
	}
}
?>