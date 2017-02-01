<?php
	$game = new Game();
	$setting_query = $conn->query("SELECT * FROM ".DB_SETTINGS." WHERE set_status=1");
	while ($row = mysqli_fetch_assoc($setting_query))
	{
		$global_settings[$row['set_name']] = $row['set_value'];
	}

	Class Game {
		public function get_new_game(){
			$conn = mysqli_connect(DATABASE_LINK, DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME) or die('error ketika connect mysql');
			$query_question = $conn->query("SELECT * FROM ".DB_QUESTION." WHERE question_status=1 ORDER BY RAND()");
			$question = mysqli_fetch_assoc($query_question);

			$query = $conn->query("UPDATE ".DB_SETTINGS." SET set_value='".$question['question_id']."' WHERE set_name='question_id'");
			if($query)
			{
				return $question['question_id'].':'.$question['question_name'];	
			}
		}

		public function get_answer($question_id){
			$conn = mysqli_connect(DATABASE_LINK, DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME) or die('error ketika connect mysql');
			$query_question = $conn->query("SELECT * FROM ".DB_QUESTION." WHERE question_id = '".$question_id."'");
			$question = mysqli_fetch_assoc($query_question);
			if($question)
			{
				return $question['question_answer'];
			}
		}

		public function get_abcd($question_id){
			$conn = mysqli_connect(DATABASE_LINK, DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME) or die('error ketika connect mysql');
			$query_question = $conn->query("SELECT * FROM ".DB_QUESTION." WHERE question_id = '".$question_id."'");
			$question = mysqli_fetch_assoc($query_question);
			if($question)
			{
				return array(array($question['question_a'], $question['question_b']),array($question['question_c'], $question['question_d']));
			}
		}
	}
?>