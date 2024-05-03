<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shishima\TranslateSpreadsheet\Facades\TranslateSpreadsheet;
use Shishima\TranslateSpreadsheet\Enumerations\TranslateEngine;
use Native\Laravel\Facades\Notification;

set_time_limit(0);
class TranslateController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        // native php
        Notification::title('Translate Spreadsheet')
            ->message('The file is processing...')
            ->show();

        $output = TranslateSpreadsheet::setTransSource($request->source)
            ->setTransTarget($request->target)
            ->highlightSheet((bool) $request->isHighlightSheet)
            ->translateSheetName((bool) $request->isTranslateSheetName)
            ->setTranslateEngine(TranslateEngine::from($request->translateEngine))
            ->translate($request->file('file'));

        // native php
        Notification::title('Translate Spreadsheet')
            ->message('Translate completed.')
            ->show();

        return response()->download($output)->deleteFileAfterSend(true);
    }
}
