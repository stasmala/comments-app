<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function addComment(CommentRequest $request)
    {
        try {
            // Use mass assignment to create the comment
            $parent_id = $request->filled('parent_id') ? $request->input('parent_id') : 0; // Default to 0 if not provided

            if ($this->validateCaptcha($request->input('captcha'), $parent_id)) {
                $comment = Comment::create([
                    'username' => $request->input('username'),
                    'email' => $request->input('email'),
                    'homepage' => $request->input('homepage'),
                    'parent_id' => $parent_id,
                    'text' => $request->input('text'),
                ]);

                return response()->json(['message' => 'Comment added successfully', 'comment' => $comment], 201);
            } else {
                return response()->json(['errors' => ['captcha' => ['Invalid CAPTCHA']]], 400);
            }

        } catch (\Exception $e) {
            \Log::error('Error adding comment: ' . $e->getMessage());

            return response()->json(['error' => 'Error adding comment'], 500);
        }
    }

    public function getComments()
    {
        try {
            $comments = Comment::with('childrenRecursive')
                ->where('parent_id', 0)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($comments, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error loading comments'], 500);
        }
    }

    public function generateCaptcha(Request $request)
    {
        $tmpId = $request->query('tmpId');

        if ($tmpId) {
            $min = 1;
            $max = 20;
            $num1 = rand($min, $max);
            $num2 = rand($min, $max);
            $operator = ['+', '-'][rand(0, 1)];

            if ($operator === '-') {
                $num1 = rand($num2, $max);
            }

            if ($operator === '+') {
                $result = $num1 + $num2;
            } else {
                $result = $num1 - $num2;
            }

            session([$tmpId => md5($result)]);

            $captchaText = "$num1 $operator $num2 = ";
            $image = imagecreate(90, 40);
            $bgColor = imagecolorallocate($image, 255, 255, 255);
            $textColor = imagecolorallocate($image, 0, 0, 0);
            imagestring($image, 5, 10, 10, $captchaText, $textColor);

            header('Content-Type: image/png');
            imagepng($image);

            imagedestroy($image);
        } else {
            return response()->json(['error' => 'tmpId is required'], 400);
        }
    }

    private function validateCaptcha($inputCaptcha, $parent_id)
    {
        $captcha_id = !empty($parent_id) ? 'captcha_' .$parent_id : 'captcha_null';

        $savedResultHash = session($captcha_id);

        return md5($inputCaptcha) === $savedResultHash;
    }
}
