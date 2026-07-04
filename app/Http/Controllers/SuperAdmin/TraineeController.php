<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Trainee;
use App\Models\Course;
use App\Models\User;
use App\Models\SmsLog;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class TraineeController extends Controller
{
 public function index(Request $request)
{
    $q = trim((string) $request->input('q'));

    $traineesQuery = Trainee::query()
        ->with(['course', 'payments', 'user', 'latestExam']);

    if ($q !== '') {
        $traineesQuery->where(function ($query) use ($q) {
            $query->where('first_name', 'like', "%{$q}%")
                ->orWhere('last_name', 'like', "%{$q}%")
                ->orWhere(DB::raw("CONCAT(first_name,' ',last_name)"), 'like', "%{$q}%")
                ->orWhere('national_code', 'like', "%{$q}%")
                ->orWhere('phone', 'like', "%{$q}%");
        });
    }

    $trainees = $traineesQuery
        ->latest()
        ->paginate(10)
        ->appends(['q' => $q]);

    return view('superadmin.trainees.index', compact('trainees', 'q'));
}



    public function create()
    {
        $courses = Course::orderBy('title')->get();

        return view('superadmin.trainees.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id'            => 'nullable|exists:courses,id',
            'first_name'           => 'required|string|max:255',
            'last_name'            => 'required|string|max:255',
            'father_name'          => 'nullable|string|max:255',
            'national_code'        => 'required|string|max:10|unique:trainees,national_code',
            'phone'                => 'required|string|max:20',
            'birth_date'           => 'nullable|date',
            'registration_status'  => 'nullable|string|max:50',
            'exam_status'          => 'nullable|string|max:50',
            'certificate_status'   => 'nullable|string|max:50',
            'total_fee'            => 'nullable|numeric|min:0',
            'discount_percent'     => 'nullable|numeric|min:0|max:100',
            'exam_fee'             => 'nullable|numeric|min:0',
            'exam_date'            => 'nullable|date',
            'exam_date_shamsi'     => 'nullable|string|max:20',
            'image'                => 'nullable|image|max:2048',
            'file'                 => 'nullable|file|max:4096',
            'note'                 => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('trainees', 'public');
        }

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('trainees', 'public');
        }

        $trainee = Trainee::create($data);

        $existingUser = User::where('phone', $trainee->phone)->first();

        if ($existingUser) {
            $existingUser->update([
                'name'       => $trainee->full_name,
                'role'       => 'trainee',
                'trainee_id' => $trainee->id,
                'password'   => $existingUser->password ?: Hash::make('password'),
            ]);
        } else {
            User::create([
                'name'       => $trainee->full_name,
                'phone'      => $trainee->phone,
                'password'   => Hash::make('password'),
                'role'       => 'trainee',
                'trainee_id' => $trainee->id,
            ]);
        }

        return redirect()
            ->route('superadmin.trainees.show', $trainee->id)
            ->with('success', 'کارآموز با موفقیت ایجاد شد')
            ->with('show_sms_box', true)
            ->with('sms_context', 'store')
            ->with('sms_message', "کارآموز گرامی {$trainee->full_name}، ثبت‌نام شما با موفقیت انجام شد.");
    }

    public function show(string $id)
    {
        $trainee = Trainee::with([
            'course',
            'payments',
            'user',
            'exams',
            'latestExam',
        ])->findOrFail($id);

        $smsLogs = SmsLog::where('mobile', $trainee->phone)
            ->orWhere(function ($query) use ($trainee) {
                $query->where('related_type', get_class($trainee))
                    ->where('related_id', $trainee->id);
            })
            ->latest()
            ->get();

        return view('superadmin.trainees.show', compact('trainee', 'smsLogs'));
    }

    public function sendSms(Request $request, string $id, SmsService $smsService)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $trainee = Trainee::findOrFail($id);

        $smsLog = $smsService->sendManual(
            $trainee->phone,
            trim($request->message),
            $trainee
        );

        if (in_array($smsLog->status, ['sent', 'test'], true)) {
            return redirect()
                ->route('superadmin.trainees.show', $trainee->id)
                ->with('success', $smsLog->status === 'test'
                    ? 'پیامک در حالت تست ثبت شد.'
                    : 'پیامک با موفقیت ارسال شد.');
        }

        return redirect()
            ->route('superadmin.trainees.show', $trainee->id)
            ->with('error', 'ارسال پیامک انجام نشد. ' . ($smsLog->error_message ?? ''));
    }

    public function edit(string $id)
    {
        $trainee = Trainee::findOrFail($id);
        $courses = Course::orderBy('title')->get();

        return view('superadmin.trainees.edit', compact('trainee', 'courses'));
    }

    public function update(Request $request, string $id)
    {
        $trainee = Trainee::findOrFail($id);

        $data = $request->validate([
            'course_id'            => 'nullable|exists:courses,id',
            'first_name'           => 'required|string|max:255',
            'last_name'            => 'required|string|max:255',
            'father_name'          => 'nullable|string|max:255',
            'national_code'        => 'required|string|max:10|unique:trainees,national_code,' . $trainee->id,
            'phone'                => 'required|string|max:20',
            'birth_date'           => 'nullable|date',
            'registration_status'  => 'nullable|string|max:50',
            'exam_status'          => 'nullable|string|max:50',
            'certificate_status'   => 'nullable|string|max:50',
            'total_fee'            => 'nullable|numeric|min:0',
            'discount_percent'     => 'nullable|numeric|min:0|max:100',
            'exam_fee'             => 'nullable|numeric|min:0',
            'exam_date'            => 'nullable|date',
            'exam_date_shamsi'     => 'nullable|string|max:20',
            'image'                => 'nullable|image|max:2048',
            'file'                 => 'nullable|file|max:4096',
            'note'                 => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($trainee->image && Storage::disk('public')->exists($trainee->image)) {
                Storage::disk('public')->delete($trainee->image);
            }

            $data['image'] = $request->file('image')->store('trainees', 'public');
        }

        if ($request->hasFile('file')) {
            if ($trainee->file && Storage::disk('public')->exists($trainee->file)) {
                Storage::disk('public')->delete($trainee->file);
            }

            $data['file'] = $request->file('file')->store('trainees', 'public');
        }

        $oldPhone = $trainee->phone;

        $trainee->update($data);

        $user = User::where('trainee_id', $trainee->id)->first()
            ?? User::where('phone', $oldPhone)->first();

        if ($user) {
            $user->update([
                'name'       => $trainee->full_name,
                'phone'      => $trainee->phone,
                'role'       => 'trainee',
                'trainee_id' => $trainee->id,
            ]);
        } else {
            User::create([
                'name'       => $trainee->full_name,
                'phone'      => $trainee->phone,
                'password'   => Hash::make('password'),
                'role'       => 'trainee',
                'trainee_id' => $trainee->id,
            ]);
        }

        return redirect()
            ->route('superadmin.trainees.show', $trainee->id)
            ->with('success', 'اطلاعات کارآموز با موفقیت ویرایش شد')
            ->with('show_sms_box', true)
            ->with('sms_context', 'update')
            ->with('sms_message', "کارآموز گرامی {$trainee->full_name}، اطلاعات شما با موفقیت بروزرسانی شد.");
    }

    public function destroy(string $id)
    {
        $trainee = Trainee::findOrFail($id);

        if ($trainee->image && Storage::disk('public')->exists($trainee->image)) {
            Storage::disk('public')->delete($trainee->image);
        }

        if ($trainee->file && Storage::disk('public')->exists($trainee->file)) {
            Storage::disk('public')->delete($trainee->file);
        }

        $user = User::where('trainee_id', $trainee->id)->first();
        if ($user) {
            $user->delete();
        }

        $trainee->delete();

        return redirect()
            ->route('superadmin.trainees.index')
            ->with('success', 'کارآموز با موفقیت حذف شد');
    }
}
