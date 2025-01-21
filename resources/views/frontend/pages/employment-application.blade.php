@extends('frontend.layouts.app')

@section('content')
    <section class="form-page container my-5">
        <form method="POST" action="{{ route('frontend.employment-application.store') }}" enctype="multipart/form-data" class="form-one gift-form">
            @csrf
            <h3>طلب توظيف</h3>
            <div class="row">
                <div class="col-12">
                    <h6>البيانات الشخصية</h6>
                    <hr>
                </div>
                <div class="col-md-6 col-12">
                    <input type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" placeholder="الاسم الثلاثي">
                    @error('full_name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6 col-12">
                    <input type="number" class="form-control" name="age" value="{{ old('age') }}" placeholder="العمر">
                    @error('age')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6 col-12">
                    <input type="number" class="form-control" name="ident_num" value="{{ old('ident_num') }}" placeholder="رقم الهوية الوطنية" required>
                    @error('ident_num')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6 col-12">
                    <select required name="gender">
                        <option disabled selected>الجنس</option>
                        <option value="male">ذكر</option>
                        <option value="female">أنثى</option>
                    </select>
                    @error('gender')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-12">
                    <h6>معلومات الاتصال</h6>
                    <hr>
                </div>
                <div class="col-md-6 col-12">
                    <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="رقم الجوال" required>
                    @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6 col-12">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="البريد الإلكتروني" required>
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-12">
                    <input type="text" class="form-control" name="city" value="{{ old('city') }}" placeholder="المدينة" required>
                    @error('city')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-12">
                    <h6>الخبرات العلمية</h6>
                    <hr>
                </div>
                <div class="col-md-6 col-12">
                    <select required name="qualification">
                        <option disabled selected>المؤهل العلمي</option>
                        <option>ثانوية عامة</option>
                        <option>دبلوم</option>
                        <option>بكالوريوس</option>
                        <option>ماجستير</option>
                        <option>دكتوراة</option>
                    </select>
                    @error('qualification')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6 col-12">
                    <input type="text" name="specialization" value="{{ old('specialization') }}" class="form-control" placeholder="التخصص" required>
                    @error('specialization')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6 col-12">
                    <select required name="do_you_work">
                        <option disabled selected>هل أنت على رأس عملك؟</option>
                        <option value="yes">نعم</option>
                        <option value="no">لا</option>
                    </select>
                    @error('do_you_work')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6 col-12">
                    <input type="number" class="form-control" name="years_of_experience" value="{{ old('years_of_experience') }}" placeholder="سنوات الخبرة" required>
                    @error('years_of_experience')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-12">
                    <input type="text" class="form-control" name="current_place_of_work" value="{{ old('current_place_of_work') }}" placeholder="مكان العمل الحالي" required>
                    @error('current_place_of_work')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-12">
                    <textarea class="form-control" name="about_your_experiences" required>نبذة عن خبراتك ومهاراتك ...</textarea>
                    @error('about_your_experiences')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-12">
                    <label><small>إرفاق السيرة الذاتية</small></label>
                    <input type="file" name="cv" class="form-control" required>
                    @error('cv')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-12">
                    <input id="done-form" type="checkbox" name="endorsement" value="ok" class="form-control" required>
                    <label for="done-form">
                        أقر بان جميع البيانات والمعلومات المدونة بهذا الطلب صحيحة مع الالتزام بمسؤوليتي الكاملة عن صحتها كما أوافق على استخدام هذه البيانات لإجراءات التسجيل دون أدنى مسؤولية قانونية
                    </label>
                    @error('endorsement')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-12">
                    <div class="form-control form-control-full">
                        <input type="submit" class="thm-btn dynamic-radius" value="إرسال">
                    </div>
                </div>
        </form>
    </section>
@endsection
