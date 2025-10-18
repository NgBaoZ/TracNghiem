<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuizController extends Controller
{
    /**
     * Bắt đầu bài thi: Lấy câu hỏi và hiển thị trang thi.
     */
    public function start()
    {
        $questions = Question::inRandomOrder()->take(30)->get();
        return view('quiz.r_quiz', ['questions' => $questions]);
    }

    /**
     * Dành cho chức năng Thi Thử
     */
    public function practice()
    {
        $questions = Question::inRandomOrder()->take(30)->get();
        return view('quiz.f_quiz', ['questions' => $questions]);
    }

    /**
     * Nộp bài: Chấm điểm và hiển thị trang kết quả.
     */
    public function submit(Request $request)
    {
        // 1. Lấy câu trả lời và danh sách ID câu hỏi (theo đúng thứ tự đã thi)
        $userAnswers = $request->input('answers', []);
        $questionIds = $request->input('question_ids', []);

        // 2. Lấy các câu hỏi từ DB nhưng chưa sắp xếp
        $unsortedQuestions = Question::whereIn('id', $questionIds)->get()->keyBy('id');

        // 3. SẮP XẾP LẠI các câu hỏi theo đúng thứ tự đã thi
        // Bằng cách lặp qua mảng ID và lấy câu hỏi tương ứng
        $questions = collect($questionIds)->map(function ($id) use ($unsortedQuestions) {
            return $unsortedQuestions[$id];
        });

        // 4. Bắt đầu chấm điểm
        $score = 0;
        foreach ($questions as $question) {
            if (isset($userAnswers[$question->id]) && strtoupper(trim($userAnswers[$question->id])) == strtoupper(trim($question->ansright))) {
                $score++;
            }
        }

        // 5. Tính toán các thông số
        $totalQuestions = $questions->count();
        $isPass = $score >= 28;

        // 6. Trả về view kết quả với dữ liệu đã được sắp xếp đúng
        return view('quiz.result', [
            'score' => $score,
            'totalQuestions' => $totalQuestions,
            'isPass' => $isPass,
            'questions' => $questions,
            'userAnswers' => $userAnswers,
        ]);
    }
}