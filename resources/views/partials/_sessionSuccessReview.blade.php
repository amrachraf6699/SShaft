@if (session('sessionSuccessReview'))
    <!-- Done Message -->
    <div class="alert-msg open">
        <div class="white-box done">
            <i class="far fa-check-circle"></i>
            <p>{{ session('sessionSuccessReview') }}</p>
            <p>{{ session('sessionSuccessReviewServiceId') }}</p>
            <h4 class="text-muted">تقييمكم لخماتنا يدفعنا للأمام</h4>
            <p>
                {{ setting()->name }} تطمح دائماً لإرضائكم وتقييمكم لنا يجعلنا نقدم أفضل ما لدينا
                <br>
                شكراً لثقتكم!
            </p>

            {!! Form::open(['route' => 'frontend.reviews.sendReview', 'method' => 'post', 'calss' => 'contact-page__form form-one mb-40']) !!}
                @csrf
                @method('POST')
                <div class="form-rate text-center">
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="stars">
                                <input class="star star-5" id="star-5" type="radio" name="rating" value="5" /> <label class="star star-5" for="star-5"></label>
                                <input class="star star-4" id="star-4" type="radio" name="rating" value="4" /> <label class="star star-4" for="star-4"></label>
                                <input class="star star-3" id="star-3" type="radio" name="rating" value="3" /> <label class="star star-3" for="star-3"></label>
                                <input class="star star-2" id="star-2" type="radio" name="rating" value="2" /> <label class="star star-2" for="star-2"></label>
                                <input class="star star-1" id="star-1" type="radio" name="rating" value="1" /> <label class="star star-1" for="star-1"></label>
                                <p class="text-center">@error('rating')<span span class="text-danger">{{ $message }}</span>@enderror</p>
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="review" rows="5" placeholder="قيم خدماتنا بالشكل الذي لاقيته منا..." class="form-control">{{ old('review') }}</textarea>
                                @error('review')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                    <!-- row -->
                    <div class="row mb-4">
                        <div class="col-12">
                            {!! Form::submit('إرسال', ['class' => 'btn-block btn-form-site']) !!}
                        </div>
                    </div>
                    <!-- /row -->
                </div>
            {!! Form::close() !!}

            <button>موافق</button>
        </div>
    </div>
    <!-- ./Done Message -->
@endif
