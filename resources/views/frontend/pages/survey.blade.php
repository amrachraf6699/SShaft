@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>{{ __('translation.surveys') }}</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>{{ __('translation.surveys') }}</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    @if ($surveys->count() > 0)
        <section class="survey-page container my-5">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>الاستبيانات</th>
                            <th>عدد الأصوات</th>
                            <th>خيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surveys as $survey)
                            <tr>
                                <td>{{ $survey->title }}</td>
                                <td>{{ $survey->total_votes }}</td>
                                <td>
                                    <button data-toggle="modal" data-target="#showsurvey{{ $survey->id }}" class="show-survey">
                                        <i class="far fa-eye"></i>
                                        عرض النتائج
                                    </button>
                                    <button data-toggle="modal" data-target="#votesurvey{{ $survey->id }}" class="vote-survey">
                                        <i class="far fa-chart-bar"></i>
                                        تصويت
                                    </button>
                                </td>
                            </tr>

                            <!-- Show Survey Modal -->
                            <div class="modal fade" id="showsurvey{{ $survey->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">عرض نتائج التصويت</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body vote-box">
                                            <p>{{ $survey->title }}</p>
                                            <ul>
                                                <li>
                                                    <span>راضٍ بشدة</span>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{ round($survey->percent_very_satisfied, 2) }}%" aria-valuenow="{{ round($survey->percent_very_satisfied, 2) }}" aria-valuemin="0" aria-valuemax="100">{{ round($survey->percent_very_satisfied, 2) }}%</div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>راضٍ نوعاً ما</span>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{ round($survey->percent_somewhat_satisfied, 2) }}%" aria-valuenow="{{ round($survey->percent_somewhat_satisfied, 2) }}" aria-valuemin="0" aria-valuemax="100">{{ round($survey->percent_somewhat_satisfied, 2) }}%</div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>محايد</span>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: {{ round($survey->percent_neutral, 2) }}%" aria-valuenow="{{ round($survey->percent_neutral, 2) }}" aria-valuemin="0" aria-valuemax="100">{{ round($survey->percent_neutral, 2) }}%</div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>غير راضٍ</span>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: {{ round($survey->percent_not_satisfied, 2) }}%" aria-valuenow="{{ round($survey->percent_not_satisfied, 2) }}" aria-valuemin="0" aria-valuemax="100">{{ round($survey->percent_not_satisfied, 2) }}%</div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>غاضب</span>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: {{ round($survey->percent_angry, 2) }}%" aria-valuenow="{{ round($survey->percent_angry, 2) }}" aria-valuemin="0" aria-valuemax="100">{{ round($survey->percent_angry, 2) }}%</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- ./Show Survey Modal -->

                            <!-- Vote Survey Modal -->
                            <div class="modal fade" id="votesurvey{{ $survey->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">تصويت</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body vote-box">
                                            <p><i>رضاك عن:</i> {{ $survey->title }}</p>
                                            <form method="POST" action="{{ route('frontend.surveys.vote.increment', $survey->id) }}">
                                                @csrf
                                                <ul>
                                                    <li>
                                                        <div class="radio-box">
                                                            <input type="radio" name="vote_status" value="very_satisfied" required>
                                                            <span>
                                                                راضٍ بشدة
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="radio-box">
                                                            <input type="radio" name="vote_status" value="somewhat_satisfied" required>
                                                            <span>
                                                                راضٍ نوعاً ما
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="radio-box">
                                                            <input type="radio" name="vote_status" value="neutral" required>
                                                            <span>
                                                                محايد
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="radio-box">
                                                            <input type="radio" name="vote_status" value="not_satisfied" required>
                                                            <span>
                                                                غير راضٍ
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="radio-box">
                                                            <input type="radio" name="vote_status" value="angry" required>
                                                            <span>
                                                                غاضب
                                                            </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                                @error('vote_status')<span class="text-danger">{{ $message }}</span>@enderror
                                                <button type="submit" class="thm-btn dynamic-radius">تصويت</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- ./Vote Survey Modal -->
                        @endforeach
                    </tbody>
                </table>
            </div>

            {!! $surveys->appends(request()->input())->links() !!}
        </section>
    @endif
@endsection

