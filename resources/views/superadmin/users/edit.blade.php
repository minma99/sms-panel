@extends('superadmin.layouts.main')

@section('title','Edit User')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('superadmin.users.update',$user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>نام</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name',$user->name) }}">
            </div>

            <div class="mb-3">
                <label>شماره موبایل</label>
                <input type="text" name="phone" class="form-control"
                       value="{{ old('phone',$user->phone) }}" required>
            </div>

            <div class="mb-3">

                <label>نقش</label>

                <select name="role" id="role" class="form-control">

                    <option value="admin" {{ old('role',$user->role)=='admin'?'selected':'' }}>
                        Admin
                    </option>

                    <option value="super_admin" {{ old('role',$user->role)=='super_admin'?'selected':'' }}>
                        Super Admin
                    </option>

                    <option value="trainee" {{ old('role',$user->role)=='trainee'?'selected':'' }}>
                        Trainee
                    </option>

                </select>

            </div>

            <div class="mb-3" id="trainee_box"
                 style="{{ old('role',$user->role)=='trainee' ? '' : 'display:none' }}">

                <label>انتخاب کارآموز</label>

                <select name="trainee_id" class="form-control">

                    <option value="">انتخاب کارآموز</option>

                    @foreach($trainees as $trainee)

                        <option value="{{ $trainee->id }}"
                        {{ old('trainee_id',$user->trainee_id)==$trainee->id ? 'selected':'' }}>

                            {{ $trainee->name }} - {{ $trainee->phone }}

                        </option>

                    @endforeach

                </select>

            </div>

            <button class="btn btn-primary">
                بروزرسانی
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
