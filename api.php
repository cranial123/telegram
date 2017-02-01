<?php
define('DEVILDIR','');
include("telegram.php");
$bot_id = "326690758:AAFLC2-Gn4hFvLMjLlAYBFwRLQcOYPrCEIM";
$telegram = new Telegram($bot_id);
$chat_id = "-186672036";
include("includes/settings.php");

$question_id = $global_settings['question_id'];
if($question_id != '')
{
	$question_answer = '/'.$game->get_answer($question_id);
}
else
{
	$question_answer = '';
}
// Get all the new updates and set the new correct update_id
if($_GET['command'] == 'receive')
{
	$req = $telegram->getUpdates();
	for ($i = 0; $i < $telegram-> UpdateCount(); $i++) {
		// You NEED to call serveUpdate before accessing the values of message in Telegram Class to avoid crash !
		$telegram->serveUpdate($i);
		$text = $telegram->Text();
		$chat_id = $telegram->ChatID();
		$date = $telegram->Date();
		$firstname = $telegram->Firstname();
		$lastname = $telegram->LastName();
		$fullname = $firstname.' '.$lastname;
		//Custom date to GMT+7
		$date = $date + 86400 * 7;

		if($question_answer == '')
		{
			if($text == "/start_quiz"){
				if ($telegram->messageFromGroup()) {
					$reply = "Ready for the Question ? Okay.. We will start in 3 Second.";
					$content = array('chat_id' => $chat_id, 'text' => $reply);
					$telegram->sendMessage($content);
					sleep(2);
					//Get the Question
					$get_data = $game->get_new_game($question_id);
					$reply_data = explode(':',$get_data);
					$reply = $reply_data[1];
					//Get the ABCD
		        	$option = $game->get_abcd($reply_data[0]);
		        	//Build the Keyboard
					$keyb = $telegram->buildKeyBoard($option);
					//Set COntent
					$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
					//Send to Telegram
					$telegram->sendMessage($content);
					sleep(2);
				}
			}
		}
		else
		{
			if($text == "/start_quiz"){
					$reply = "Another Quiz on Progress...";
					$content = array('chat_id' => $chat_id, 'text' => $reply);
					$telegram->sendMessage($content);
				}
			if($text == @$question_answer)
			{
					$reply = "Congratulation ".$fullname." You correct !";
					$content = array('chat_id' => $chat_id, 'text' => $reply);
					$telegram->sendMessage($content);
					sleep(2);
					$reply = "Ready for the Next Question ? Okay.. We will start in 3 Second.";
					$content = array('chat_id' => $chat_id, 'text' => $reply);
					$telegram->sendMessage($content);
					sleep(2);
					//Get the Question
					$get_data = $game->get_new_game($question_id);
					$reply_data = explode(':',$get_data);
					$reply = $reply_data[1];
					//Get the ABCD
		        	$option = $game->get_abcd($reply_data[0]);
		        	//Build the Keyboard
					$keyb = $telegram->buildKeyBoard($option);
					//Set COntent
					$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
					//Send to Telegram
					$telegram->sendMessage($content);
					sleep(2);
			}
		}

	}
	if(isset($date) && isset($text))
	{
		//echo '<span style="color:#f00;">'.date('d-m-Y, H:i:s',$date).' : '.$text.'<br></span>';
		echo '<span style="color:#f00;">[Administrator] ['.date('H:i:s',$date).'] : '.$text.'<br></span>';
	}
}
if($_GET['command'] == 'send')
{
	$content = array('chat_id' => $chat_id, 'text' => $_GET['text']);
	$telegram->sendMessage($content);
}
