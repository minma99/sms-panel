public function show(string $id)
{
    $trainee = Trainee::with([
        'course',
        'payments',
        'user',
        'exams',
        'latestExam',
    ])->findOrFail($id);

    $smsLogs = \App\Models\SmsLog::where('mobile', $trainee->phone)
        ->orWhere(function ($query) use ($trainee) {
            $query->where('related_type', get_class($trainee))
                  ->where('related_id', $trainee->id);
        })
        ->latest()
        ->get();

    return view('superadmin.trainees.show', compact('trainee', 'smsLogs'));
}
