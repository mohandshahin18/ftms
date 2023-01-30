<?php

use App\Models\Question;

function get_question_name($id)
{
      $question = Question::select('question')->findOrFail($id);
      return $question->question;
}