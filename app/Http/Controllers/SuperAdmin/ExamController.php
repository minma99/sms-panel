<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Trainee;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with('trainee');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('trainee', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('national_code', 'like', "%{$search}%");
            })->orWhere('exam_title', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $exams = $query->latest()->paginate(15);

        return view('superadmin.exams.index', compact('exams'));
    }

    public function create(Request $request)
    {
        $trainees = Trainee::all();
        $selected_trainee = null;
        $prefilled_exam = null;

        if ($request->has('retest_from')) {
            $prefilled_exam = Exam::findOrFail($request->retest_from);
            $selected_trainee = $prefilled_exam->trainee_id;
        } elseif ($request->has('trainee_id')) {
            $selected_trainee = $request->trainee_id;
        }

        return view('superadmin.exams.create', compact('trainees', 'selected_trainee', 'prefilled_exam'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trainee_id'  => 'required|exists:trainees,id',
            'exam_title'  => 'required|string|max:255',
            'exam_date'   => 'required|date',
            'start_time'  => 'nullable',
            'end_time'    => 'nullable',
            'exam_type'   => 'required|string',
            'location'    => 'nullable|string|max:255',
            'status'      => 'required|string',
            'note'        => 'nullable|string',
        ]);

        $exam = Exam::create($validated);
        $trainee = Trainee::findOrFail($validated['trainee_id']);

        $smsMessage = "کارآموز گرامی {$trainee->full_name}، شما برای آزمون «{$exam->exam_title}» در تاریخ {$exam->exam_date} معرفی/ثبت شدید.";

        return redirect()
            ->route('superadmin.trainees.show', $trainee->id)
            ->with('success', 'آزمون جدید با موفقیت ثبت شد.')
            ->with('show_sms_box', true)
            ->with('sms_message', $smsMessage)
            ->with('sms_context', 'exam_created');
    }

    public function edit(Exam $exam)
    {
        $trainees = Trainee::all();

        return view('superadmin.exams.edit', compact('exam', 'trainees'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'trainee_id'  => 'required|exists:trainees,id',
            'exam_title'  => 'required|string|max:255',
            'exam_date'   => 'required|date',
            'start_time'  => 'nullable',
            'end_time'    => 'nullable',
            'exam_type'   => 'required|string',
            'location'    => 'nullable|string|max:255',
            'status'      => 'required|string',
            'note'        => 'nullable|string',
        ]);

        $exam->update($validated);
        $trainee = Trainee::findOrFail($validated['trainee_id']);

        $smsMessage = "کارآموز گرامی {$trainee->full_name}، اطلاعات آزمون شما با موفقیت بروزرسانی شد. عنوان آزمون: {$exam->exam_title}.";

        return redirect()
            ->route('superadmin.trainees.show', $trainee->id)
            ->with('success', 'اطلاعات آزمون با موفقیت بروزرسانی شد.')
            ->with('show_sms_box', true)
            ->with('sms_message', $smsMessage)
            ->with('sms_context', 'exam_updated');
    }

    public function destroy(Exam $exam)
    {
        $traineeId = $exam->trainee_id;

        $exam->delete();

        return redirect()
            ->route('superadmin.trainees.show', $traineeId)
            ->with('success', 'آزمون مورد نظر حذف شد.');
    }
}
