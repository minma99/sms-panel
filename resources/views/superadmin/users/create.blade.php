@extends('superadmin.layouts.main')

@section('title','Create User')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('superadmin.users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>نام</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label>شماره موبایل</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
            </div>

            <div class="mb-3">
                <label>نقش</label>

                <select name="role" id="role" class="form-control">

                    <option value="admin" {{ old('role')=='admin'?'selected':'' }}>
                        Admin
                    </option>

                    <option value="super_admin" {{ old('role')=='super_admin'?'selected':'' }}>
                        Super Admin
                    </option>

                    <option value="trainee" {{ old('role')=='trainee'?'selected':'' }}>
                        Trainee
                    </option>

                </select>
            </div>

            <div class="mb-3" id="trainee_box" style="display:none">

                <label>انتخاب کارآموز</label>

                <select name="trainee_id" class="form-control">

                    <option value="">انتخاب کارآموز</option>

                    @foreach($trainees as $trainee)

                        <option value="{{ $trainee->id }}">
                            {{ $trainee->name }} - {{ $trainee->phone }}
                        </option>

                    @endforeach

                </select>

            </div>

            <button class="btn btn-success">
                ذخیره
            </button>

        </form>

    </div>
</div>

<script>

let role = document.getElementById('role')
let traineeBox = document.getElementById('trainee_box')

function toggleTrainee(){

    if(role.value === 'trainee'){
        traineeBox.style.display = 'block'
    }else{
        traineeBox.style.display = 'none'
    }

}

role.addEventListener('change',toggleTrainee)

toggleTrainee()

</script>

@endsection
