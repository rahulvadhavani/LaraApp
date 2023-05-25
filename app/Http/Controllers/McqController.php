<?php

namespace App\Http\Controllers;

use App\Models\MCQ;
use App\Models\MCQOption;
use Illuminate\Http\Request;

class McqController extends Controller
{
    public function index()
    {
        $module = 'MCQs';
        $mcqs = MCQ::paginate(5);      
        return view('mcqs.index', compact('mcqs','module'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $module = 'MCQ Create';
        return view('mcqs.create',compact('module'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|max:255',
            'options' => 'required|array',
            'options.*' => 'max:255',
            'correct_answer' => 'required|integer',
        ]);

        $mcq = MCQ::create([
            'question' => $request->question,
        ]);

        foreach ($request->options as $index => $optionText) {
            $isCorrect = ($index == $request->correct_answer);
            MCQOption::create([
                'mcq_id' => $mcq->id,
                'option' => $optionText,
                'is_correct' => $isCorrect,
            ]);
        }
        return redirect()->route('mcqs.index')
        ->with('success', 'Mcq created successfully.');
    }

    public function show(MCQ $mcq)
    {
        $module = 'MCQ Detail';
        $mcq->load('options');
        return view('mcqs.show', compact('mcq','module'));
    }

    public function edit(MCQ $mcq)
    {
        $module = 'MCQ Edit';
        $mcq->load('options');
        return view('mcqs.edit', compact('mcq','module'));
    }

    public function update(Request $request, MCQ $mcq)
    {
        $request->validate([
            'question' => 'required|max:255',
            'options' => 'required|array',
            'options.*' => 'max:255',
            'correct_answer' => 'required|integer',
        ]);

        $mcq->update([
            'question' => $request->question,
        ]);

        // Delete existing options
        $mcq->options()->delete();
        foreach ($request->options as $index => $optionText) {
            $isCorrect = ($index == $request->correct_answer);
            MCQOption::create([
                'mcq_id' => $mcq->id,
                'option' => $optionText,
                'is_correct' => $isCorrect,
            ]);
        }
        return redirect()->route('mcqs.index')
        ->with('success', 'Mcq updated successfully.');
    }

    public function destroy(MCQ $mcq)
    {
        $mcq->delete();
        return redirect()->route('mcqs.index')
        ->with('success', 'Mcq deleted successfully.');
    }
}
