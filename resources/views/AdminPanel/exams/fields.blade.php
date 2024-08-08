@isset($exam)
    @method('PUT')
    <input type="hidden" value="{{ $exam->id }}" name="id">
@endisset
@csrf
<div class="card-body border-top p-9">
    <ul class="nav nav-light-success nav-pills" id="myTab" role="tablist">
        @foreach (LaravelLocalization::getSupportedLocales() as $name => $value)
            <li class="nav-item">
                <a class="nav-link {{ LaravelLocalization::getCurrentLocale() == $name ? 'active' : '' }}" id="{{ $name }}-tab"
                   data-bs-toggle="tab" href="#{{ $name }}" role="tab" aria-controls="{{ $name }}"
                   aria-selected="{{ LaravelLocalization::getCurrentLocale() == $name ? 'true' : 'false' }}">{{ $value['native'] }}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content mt-5" id="myTabContent">
        @foreach (LaravelLocalization::getSupportedLocales() as $name => $value)
            <div class="tab-pane fade {{ LaravelLocalization::getCurrentLocale() == $name ? 'show active' : '' }}" id="{{ $name }}" role="tabpanel" aria-labelledby="{{ $name }}-tab">
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.name') }}</label>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <input type="text" name="{{ $name }}[name]"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       value="{{ isset($exam) ? $exam->getTranslation($name)->name : '' }}" placeholder="{{ __('lang.name') }}">
                                @if($errors->has("{$name}.name"))
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        {{ $errors->first("{$name}.name") }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Course') }}</label>
            <div class="col-lg-8">
                <select id="course_id" name="course_id" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" onchange="fetchLessons(this.value)">
                    <option value="">{{ __('Select Course') }}</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id', isset($exam) ? $exam->lesson->course_id : '') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Lesson') }}</label>
            <div class="col-lg-8">
                <select id="lesson_id" name="lesson_id" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
                    <option value="">{{ __('Select Lesson') }}</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ old('lesson_id', isset($exam) ? $exam->lesson_id : '') == $lesson->id ? 'selected' : '' }}>{{ $lesson->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Exam Type') }}</label>
            <div class="col-lg-8">
                <select id="type" name="type" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" onchange="updateQuestionInputs(this.value)">
                    <option value="">{{ __('Select Exam Type') }}</option>
                    <option value="true_false" {{ old('type', isset($exam) ? $exam->type : '') == 'true_false' ? 'selected' : '' }}>{{ __('True/False') }}</option>
                    <option value="multiple_choice" {{ old('type', isset($exam) ? $exam->type : '') == 'multiple_choice' ? 'selected' : '' }}>{{ __('Multiple Choice') }}</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Questions') }}</label>

            <div class="fv-row mb-8 col-2">
                <div class="btn btn-secondary btn-xs add-select-question py-0" counter="{{ (isset($exam) && $exam->questions->count()>0) ? $exam->questions->sortByDesc('id')->first()->id : 0 }}">+</div>
            </div>
            <div class="row mb-3 questions">
                @if(isset($exam) && isset($exam->questions))
                    @foreach ($exam->questions as $i => $question)
                        <div class="row question">
                            <input type="hidden" name="questions[{{$i}}][id]" value="{{$question->id}}">
                            <div class="col-8 d-flex">
                                @foreach (LaravelLocalization::getSupportedLocales() as $name => $value)
                                    <input name="questions[{{$i}}][{{$name}}][question]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 mr-5" placeholder="{{ __('Question') }}" value="{{ $question->getTranslationOrNew($name)->question ?? '' }}">
                                @endforeach
                            </div>
                            <div class="col-2">
                                <span class="btn btn-danger btn-xs pull-right btn-del-select py-0 del-question" data-question-id="{{ $question->id }}"><i class="bi bi-file-x-fill"></i></span>
                            </div>

                            <div class="answers-container col-12">
                                @foreach (LaravelLocalization::getSupportedLocales() as $locale => $value)
                                    <div class="col-12 mb-3">
                                        <label class="form-label">{{ __('Answers in') }} {{ $value['native'] }}</label>
                                        @if($exam->type == 'true_false')
                                            <div class="input-group mb-3">
                                                <input type="text" name="questions[{{$i}}][answers][0][{{$locale}}][answer]" class="form-control form-control-lg form-control-solid" placeholder="{{ __('Answer 1') }}" value="{{ $question->answers[0]->getTranslationOrNew($locale)->answer ?? '' }}">
                                                <div class="input-group-text">
                                                    <input type="radio" name="questions[{{$i}}][correct_answer]" value="0" {{ $question->answers[0]->getTranslationOrNew($locale)->is_correct ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="text" name="questions[{{$i}}][answers][1][{{$locale}}][answer]" class="form-control form-control-lg form-control-solid" placeholder="{{ __('Answer 2') }}" value="{{ $question->answers[1]->getTranslationOrNew($locale)->answer ?? '' }}">
                                                <div class="input-group-text">
                                                    <input type="radio" name="questions[{{$i}}][correct_answer]" value="1" {{ $question->answers[1]->getTranslationOrNew($locale)->is_correct ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        @elseif($exam->type == 'multiple_choice')
                                            @for($j = 0; $j < 4; $j++)
                                                <div class="input-group mb-3">
                                                    @isset($question->answers[$j])
                                                        <input type="text" name="questions[{{$i}}][answers][{{$j}}][{{$locale}}][answer]" class="form-control form-control-lg form-control-solid" placeholder="{{ __('Answer') }} {{$j+1}}" value="{{ $question->answers[$j]->getTranslationOrNew($locale)->answer ?? '' }}">
                                                        <div class="input-group-text">
                                                            <input type="radio" name="questions[{{$i}}][correct_answer]" value="{{$j}}" {{ $question->answers[$j]->getTranslationOrNew($locale)->is_correct ? 'checked' : '' }}>
                                                        </div>
                                                    @else
                                                        <input type="text" name="questions[{{$i}}][answers][{{$j}}][{{$locale}}][answer]" class="form-control form-control-lg form-control-solid" placeholder="{{ __('Answer') }} {{$j+1}}">
                                                        <div class="input-group-text">
                                                            <input type="radio" name="questions[{{$i}}][correct_answer]" value="{{$j}}">
                                                        </div>
                                                    @endisset
                                                </div>
                                            @endfor
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function fetchLessons(courseId) {
        fetch(`/courses/${courseId}/lessons`)
            .then(response => response.json())
            .then(data => {
                let lessonSelect = document.getElementById('lesson_id');
                lessonSelect.innerHTML = '<option value="">{{ __('Select Lesson') }}</option>';
                data.forEach(lesson => {
                    let option = document.createElement('option');
                    option.value = lesson.id;
                    option.text = lesson.name;
                    lessonSelect.appendChild(option);
                });
            });
    }

    function updateQuestionInputs(examType) {
        let questionsSections = document.querySelectorAll('.questions-section');
        questionsSections.forEach(section => {
            section.style.display = examType ? 'block' : 'none';
        });

        let questionsContainers = document.querySelectorAll('.questions-container');
        questionsContainers.forEach(container => {
            let answersContainer = container.querySelector('.answers-container');
            if (answersContainer) {
                answersContainer.innerHTML = '';
                if (examType === 'true_false') {
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $value)
                        answersContainer.innerHTML += `
                            <div class="col-12 mb-3">
                                <label class="form-label">{{ __('Answers in') }} {{ $value['native'] }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="questions[0][answers][0][{{$locale}}][answer]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __('Answer 1') }}">
                                    <div class="input-group-text">
                                        <input type="radio" name="questions[0][correct_answer]" value="0">
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" name="questions[0][answers][1][{{$locale}}][answer]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __('Answer 2') }}">
                                    <div class="input-group-text">
                                        <input type="radio" name="questions[0][correct_answer]" value="1">
                                    </div>
                                </div>
                            </div>
                        `;
                    @endforeach
                } else if (examType === 'multiple_choice') {
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $value)
                        answersContainer.innerHTML += `
                            <div class="col-12 mb-3">
                                <label class="form-label">{{ __('Answers in') }} {{ $value['native'] }}</label>
                                @for($j = 0; $j < 4; $j++)
                                    <div class="input-group mb-3">
                                        <input type="text" name="questions[0][answers][{{$j}}][{{$locale}}][answer]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __('Answer') }} {{$j+1}}">
                                        <div class="input-group-text">
                                            <input type="radio" name="questions[0][correct_answer]" value="{{$j}}">
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        `;
                    @endforeach
                }
            }
        });
    }

    document.addEventListener('click', function (event) {
        if (event.target.matches('.add-select-question')) {
            let counter = event.target.getAttribute('counter');
            counter++;
            let questionsContainer = document.querySelector('.questions');
            let examType = document.getElementById('type').value;
            let newQuestionHtml = '';

            if (examType === 'true_false') {
                newQuestionHtml = `
                    <div class="row question">
                        <input type="hidden" name="questions[${counter}][id]" value="${counter}">
                        <div class="col-8 d-flex">
                            @foreach (LaravelLocalization::getSupportedLocales() as $name => $value)
                                <input name="questions[${counter}][{{$name}}][question]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 mr-5" placeholder="{{ __('Question') }} {{$name}}">
                            @endforeach
                        </div>
                        <div class="col-2">
                            <span class="btn btn-danger btn-xs pull-right btn-del-select py-0 del-question" data-question-id="${counter}"><i class="bi bi-file-x-fill"></i></span>
                        </div>
                        <div class="answers-container col-12">
                            @foreach (LaravelLocalization::getSupportedLocales() as $name => $value)
                                <div class="col-12 mb-3">
                                    <label class="form-label">{{ __('Answers in') }} {{ $value['native'] }}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="questions[${counter}][answers][0][{{$name}}][answer]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __('Answer 1') }}">
                                        <div class="input-group-text">
                                            <input type="radio" name="questions[${counter}][correct_answer]" value="0">
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" name="questions[${counter}][answers][1][{{$name}}][answer]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __('Answer 2') }}">
                                        <div class="input-group-text">
                                            <input type="radio" name="questions[${counter}][correct_answer]" value="1">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>`;
            } else if (examType === 'multiple_choice') {
                newQuestionHtml = `
                    <div class="row question">
                        <input type="hidden" name="questions[${counter}][id]" value="${counter}">
                        <div class="col-8 d-flex">
                            @foreach (LaravelLocalization::getSupportedLocales() as $name => $value)
                                <input name="questions[${counter}][{{$name}}][question]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 mr-5" placeholder="{{ __('Question') }} {{$name}}">
                            @endforeach
                        </div>
                        <div class="col-2">
                            <span class="btn btn-danger btn-xs pull-right btn-del-select py-0 del-question" data-question-id="${counter}"><i class="bi bi-file-x-fill"></i></span>
                        </div>
                        <div class="answers-container col-12">
                            @foreach (LaravelLocalization::getSupportedLocales() as $name => $value)
                                <div class="col-12 mb-3">
                                    <label class="form-label">{{ __('Answers in') }} {{ $value['native'] }}</label>
                                    @for($j = 0; $j < 4; $j++)
                                        <div class="input-group mb-3">
                                            <input type="text" name="questions[${counter}][answers][{{$j}}][{{$name}}][answer]" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __('Answer') }} {{$j+1}}">
                                            <div class="input-group-text">
                                                <input type="radio" name="questions[${counter}][correct_answer]" value="{{$j}}">
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            @endforeach
                        </div>
                    </div>`;
            }

            questionsContainer.insertAdjacentHTML('beforeend', newQuestionHtml);
            event.target.setAttribute('counter', counter);
        }

        if (event.target.matches('.del-question')) {
            event.target.closest('.question').remove();
        }
    }, false);
</script>
