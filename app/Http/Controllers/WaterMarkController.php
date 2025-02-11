<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaterMarkController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'fileimage' => 'required|file|mimes:png,jpg|max:5210',
            'message' => 'required|string|min:10|max:20',
        ]);

        $file = $request->file('fileimage');
        $text = $request->input('message');

        return response()->stream(function () use ($file, $text) {
            $image = imagecreatefromjpeg($file);

            $textColor = imagecolorallocate($image, 255, 255, 255);

            $fontSize = 5;
            $margin = 10;

            $textWidth = imagefontwidth($fontSize) * strlen($text);
            $textHeight = imagefontheight($fontSize);

            $x = imagesx($image) - $textWidth - $margin;
            $y = imagesy($image) - $textHeight - $margin;

            imagestring($image, $fontSize, $x, $y, $text, $textColor);

            header('Content-type: image/jpeg');

            imagejpeg($image);

            imagedestroy($image);
        }, 200, ['Content-Type' => 'image/jpeg']);
    }
}
