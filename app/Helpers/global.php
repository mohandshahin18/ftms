<?php

use App\Models\Question;

// function get_question_name($id)
// {
//       $question = Question::findOrFail($id)->pluck('question', 'id');
//       return $question;
// }

function get_question_name($id)
{
    static $questions = null;

    if (is_null($questions)) {
        $questions = Question::all()->pluck('question', 'id');
    }

    return $questions->get($id);
}