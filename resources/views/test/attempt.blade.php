@extends('test.layout')

@section('title', $test->name)

@section('content')

<div class="min-h-screen bg-[#f7f9fc]">

    {{-- ================= TEST HEADER ================= --}}
    <div class="sticky top-0 z-40 border-b border-[#e4e8ef] bg-white shadow-sm">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <div class="flex min-h-16 items-center justify-between gap-4">

                <div class="min-w-0">
                    <p class="truncate text-xs font-medium text-[#2874b9]">
                        {{ $test->testSeries->name ?? 'Test Series' }}
                    </p>

                    <h1 class="truncate text-sm font-bold text-[#1f2937] sm:text-base">
                        {{ $test->name }}
                    </h1>
                </div>

                <div
                    id="timerBox"
                    class="flex shrink-0 items-center gap-2 rounded-lg border border-[#e4e8ef] bg-[#f8fafc] px-3 py-2"
                >
                    <i
                        data-lucide="clock-3"
                        class="h-4 w-4 text-[#2874b9]"
                    ></i>

                    <span
                        id="timer"
                        class="font-mono text-sm font-bold text-[#1f2937]"
                    >
                        00:00
                    </span>
                </div>

            </div>

        </div>
    </div>


    {{-- ================= MAIN ================= --}}
    <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">

        <form
            id="testForm"
            method="POST"
            action="{{ route('student.test.submit', $attempt) }}"
        >
            @csrf

            <div class="grid gap-5 lg:grid-cols-[1fr_280px]">

                {{-- ================= QUESTION AREA ================= --}}
                <div class="min-w-0">

                    <div
                        class="rounded-xl border border-[#e4e8ef] bg-white p-5 shadow-sm sm:p-6"
                    >

                        {{-- Loading --}}
                        <div
                            id="questionLoading"
                            class="hidden py-12 text-center"
                        >
                            <div class="mx-auto mb-3 h-7 w-7 animate-spin rounded-full border-2 border-[#2874b9] border-t-transparent"></div>

                            <p class="text-sm text-[#667085]">
                                Loading question...
                            </p>
                        </div>


                        {{-- Error --}}
                        <div
                            id="questionError"
                            class="hidden rounded-lg border border-red-200 bg-red-50 p-4 text-center"
                        >
                            <p class="text-sm font-semibold text-red-700">
                                Unable to load question
                            </p>

                            <button
                                type="button"
                                onclick="retryCurrentQuestion()"
                                class="mt-3 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                            >
                                <i
                                    data-lucide="refresh-cw"
                                    class="h-4 w-4"
                                ></i>

                                Try Again
                            </button>
                        </div>


                        {{-- Question Content --}}
                        <div id="questionContent">

                            <div class="flex items-start justify-between gap-3">

                                <div class="min-w-0">

                                    <p
                                        id="questionNumber"
                                        class="text-xs font-semibold uppercase tracking-wide text-[#98a2b3]"
                                    >
                                        Question 1 of {{ $totalQuestions }}
                                    </p>

                                    <h2
                                        id="questionText"
                                        class="mt-2 text-base font-semibold leading-6 text-[#1f2937] sm:text-lg"
                                    ></h2>

                                </div>

                                <span
                                    id="questionMarks"
                                    class="shrink-0 rounded-md bg-[#eef6ff] px-2 py-1 text-xs font-semibold text-[#2874b9]"
                                >
                                    0 Mark
                                </span>

                            </div>


                            {{-- Options --}}
                            <div
                                id="optionsContainer"
                                class="mt-6 space-y-3"
                            ></div>


                            {{-- Navigation --}}
                            <div class="mt-6 flex items-center justify-between border-t border-[#edf0f4] pt-5">

                                <button
                                    type="button"
                                    onclick="previousQuestion()"
                                    id="previousButton"
                                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#667085] transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40"
                                >
                                    <i
                                        data-lucide="arrow-left"
                                        class="h-4 w-4"
                                    ></i>

                                    Previous
                                </button>


                                <button
                                    type="button"
                                    onclick="nextQuestion()"
                                    id="nextButton"
                                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21649f]"
                                >
                                    Next

                                    <i
                                        data-lucide="arrow-right"
                                        class="h-4 w-4"
                                    ></i>
                                </button>

                            </div>

                        </div>

                    </div>


                    {{-- ================= SUBMIT BOX ================= --}}
                    <div class="mt-5 rounded-xl border border-red-100 bg-red-50 p-4">

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                            

                            <button
                                type="button"
                                onclick="openSubmitModal()"
                                class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700"
                            >
                                <i
                                    data-lucide="send"
                                    class="h-4 w-4"
                                ></i>

                                Submit Test
                            </button>

                        </div>

                    </div>

                </div>


                {{-- ================= SIDEBAR ================= --}}
                <aside
                    class="h-fit rounded-xl border border-[#e4e8ef] bg-white p-4 shadow-sm lg:sticky lg:top-24"
                >

                    <div class="mb-4">

                        <h2 class="text-sm font-semibold text-[#1f2937]">
                            Questions
                        </h2>

                        <p class="mt-1 text-xs text-[#667085]">
                            Navigate between questions.
                        </p>

                    </div>


                    {{-- Question Navigation --}}
                    <div
                        id="questionNavigation"
                        class="grid grid-cols-5 gap-2"
                    >

                        @for($i = 1; $i <= $totalQuestions; $i++)

                            <button
                                type="button"
                                id="questionNav{{ $i }}"
                                onclick="showQuestion({{ $i }})"
                                class="question-nav h-9 w-9 cursor-pointer rounded-lg border border-[#d0d5dd] text-xs font-semibold text-[#667085] transition hover:border-[#2874b9] hover:text-[#2874b9]"
                            >
                                {{ $i }}
                            </button>

                        @endfor

                    </div>


                    {{-- Legend --}}
                    <div class="mt-5 border-t border-[#edf0f4] pt-4">

                        <div class="flex items-center gap-2 py-1.5">
                            <span class="h-3 w-3 rounded border border-[#d0d5dd] bg-white"></span>

                            <span class="text-xs text-[#667085]">
                                Not answered
                            </span>
                        </div>


                        <div class="flex items-center gap-2 py-1.5">
                            <span class="h-3 w-3 rounded bg-[#eef6ff]"></span>

                            <span class="text-xs text-[#667085]">
                                Current
                            </span>
                        </div>


                        <div class="flex items-center gap-2 py-1.5">
                            <span class="h-3 w-3 rounded bg-green-100"></span>

                            <span class="text-xs text-[#667085]">
                                Answered
                            </span>
                        </div>

                    </div>


                    {{-- Test Info --}}
                    <div class="mt-4 border-t border-[#edf0f4] pt-4">

                        <div class="flex items-center justify-between py-2">

                            <span class="text-xs text-[#667085]">
                                Questions
                            </span>

                            <span class="text-sm font-semibold text-[#1f2937]">
                                {{ $totalQuestions }}
                            </span>

                        </div>


                        <div class="flex items-center justify-between py-2">

                            <span class="text-xs text-[#667085]">
                                Duration
                            </span>

                            <span class="text-sm font-semibold text-[#1f2937]">
                                {{ $test->duration }} min
                            </span>

                        </div>


                        <div class="flex items-center justify-between py-2">

                            <span class="text-xs text-[#667085]">
                                Total Marks
                            </span>

                            <span class="text-sm font-semibold text-[#1f2937]">
                                {{ $test->total_marks }}
                            </span>

                        </div>

                    </div>

                </aside>

            </div>

        </form>

    </div>

</div>


{{-- ================= SUBMIT MODAL ================= --}}
<div
    id="submitModal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 px-4"
>

    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">

        <div class="flex items-start gap-4">

            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-red-100">
                <i
                    data-lucide="send"
                    class="h-5 w-5 text-red-600"
                ></i>
            </div>

            <div>

                <h3 class="text-lg font-bold text-[#1f2937]">
                    Submit Test?
                </h3>

                <p class="mt-1 text-sm leading-6 text-[#667085]">
                    Are you sure you want to submit this test?
                    You will not be able to change your answers after submission.
                </p>

            </div>

        </div>


        <div class="mt-6 flex justify-end gap-3">

            <button
                type="button"
                onclick="closeSubmitModal()"
                class="cursor-pointer rounded-lg border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] hover:bg-gray-50"
            >
                Cancel
            </button>


            <button
                type="button"
                onclick="submitTest()"
                class="cursor-pointer rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700"
            >
                Yes, Submit
            </button>

        </div>

    </div>

</div>


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       CONFIG
    ========================================================= */

    const totalQuestions =
        {{ $totalQuestions }};

    let currentQuestion = 1;

    let remainingSeconds =
        {{ $remainingSeconds }};

    let isSubmitting = false;

    let isLoading = false;

    /*
     * Cache questions in browser memory.
     *
     * Example:
     * questionCache[1] = question 1
     * questionCache[2] = question 2
     *
     * This removes the visible delay when moving next.
     */
    const questionCache = {};

    /*
     * Requests already running.
     */
    const loadingRequests = {};

    const questionUrlTemplate =
        "{{ route('student.test.question', ['attempt' => $attempt, 'number' => '__NUMBER__']) }}";


    const saveAnswerUrl =
        "{{ route('student.test.save-answer', $attempt) }}";


    const csrfToken =
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content');


    const questionStorageKey =
        'test_current_question_{{ $attempt->id }}';


    /* =========================================================
       DOM
    ========================================================= */

    const questionLoading =
        document.getElementById('questionLoading');

    const questionError =
        document.getElementById('questionError');

    const questionContent =
        document.getElementById('questionContent');

    const questionNumber =
        document.getElementById('questionNumber');

    const questionText =
        document.getElementById('questionText');

    const questionMarks =
        document.getElementById('questionMarks');

    const optionsContainer =
        document.getElementById('optionsContainer');

    const previousButton =
        document.getElementById('previousButton');

    const nextButton =
        document.getElementById('nextButton');

    const timer =
        document.getElementById('timer');

    const timerBox =
        document.getElementById('timerBox');


    /* =========================================================
       URL
    ========================================================= */

    function getQuestionUrl(number)
    {
        return questionUrlTemplate.replace(
            '__NUMBER__',
            number
        );
    }


    /* =========================================================
       SHOW / HIDE LOADING
    ========================================================= */

    function showLoading()
    {
        questionLoading.classList.remove('hidden');
        questionContent.classList.add('hidden');
        questionError.classList.add('hidden');
    }


    function hideLoading()
    {
        questionLoading.classList.add('hidden');
        questionContent.classList.remove('hidden');
    }


    /* =========================================================
       LOAD QUESTION FROM SERVER
    ========================================================= */

    async function fetchQuestion(number)
    {
        /*
         * Already cached?
         * Return immediately.
         */
        if (questionCache[number]) {
            return questionCache[number];
        }


        /*
         * Already loading?
         * Reuse same Promise.
         */
        if (loadingRequests[number]) {
            return loadingRequests[number];
        }


        const request =
            fetch(
                getQuestionUrl(number),
                {
                    method: 'GET',

                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },

                    credentials: 'same-origin'
                }
            )
            .then(async response => {

                if (!response.ok) {

                    let message =
                        'Unable to load question.';

                    try {

                        const data =
                            await response.json();

                        if (data.message) {
                            message = data.message;
                        }

                    } catch (error) {
                        // Ignore JSON parsing error.
                    }

                    throw new Error(message);
                }


                const data =
                    await response.json();


                /*
                 * Save in cache.
                 */
                questionCache[number] =
                    data;


                return data;

            })
            .finally(() => {

                delete loadingRequests[number];

            });


        loadingRequests[number] =
            request;


        return request;
    }


    /* =========================================================
       RENDER QUESTION
    ========================================================= */

    function renderQuestion(data)
    {
        questionNumber.textContent =
            `Question ${data.number} of ${data.total}`;


        questionText.textContent =
            data.question;


        questionMarks.textContent =
            `${data.marks ?? 0} Mark`;


        optionsContainer.innerHTML =
            '';


        const options = [
            {
                key: 'A',
                text: data.option_a
            },
            {
                key: 'B',
                text: data.option_b
            },
            {
                key: 'C',
                text: data.option_c
            },
            {
                key: 'D',
                text: data.option_d
            }
        ];


        options.forEach(option => {

            const label =
                document.createElement('label');

            label.className =
                'option-label flex cursor-pointer items-start gap-3 rounded-xl border border-[#e4e8ef] p-4 transition hover:border-[#2874b9]/40 hover:bg-[#f8fbff]';


            const input =
                document.createElement('input');

            input.type =
                'radio';

            input.name =
                'current_answer';

            input.value =
                option.key;

            input.className =
                'answer-radio mt-1 h-4 w-4 border-gray-300 text-[#2874b9] focus:ring-[#2874b9]';

            input.dataset.questionId =
                data.id;

            input.dataset.questionNumber =
                data.number;


            const textWrapper =
                document.createElement('span');

            textWrapper.className =
                'flex-1 text-sm leading-6 text-[#344054]';


            const letter =
                document.createElement('span');

            letter.className =
                'mr-2 font-bold text-[#2874b9]';

            letter.textContent =
                option.key + '.';


            textWrapper.appendChild(letter);

            textWrapper.appendChild(
                document.createTextNode(
                    option.text ?? ''
                )
            );


            label.appendChild(input);

            label.appendChild(textWrapper);

            optionsContainer.appendChild(label);


            input.addEventListener(
                'change',
                function () {

                    saveAnswer(
                        data.id,
                        this.value,
                        data.number
                    );

                    markAnswered(
                        data.number
                    );

                }
            );

        });


        /*
         * Restore previously saved answer.
         */
        if (data.selected_answer) {

            const selected =
                optionsContainer.querySelector(
                    `input[value="${data.selected_answer}"]`
                );

            if (selected) {
                selected.checked = true;
            }
        }


        updateNavigationButtons(
            data.number
        );


        updateQuestionNav(
            data.number,
            !!data.selected_answer
        );


        /*
         * Re-render Lucide icons if available.
         */
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }


    /* =========================================================
       DISPLAY QUESTION
    ========================================================= */

    async function loadQuestion(number)
    {
        if (
            number < 1 ||
            number > totalQuestions
        ) {
            return;
        }


        /*
         * If cached, render immediately.
         */
        if (questionCache[number]) {

            currentQuestion =
                number;

            sessionStorage.setItem(
                questionStorageKey,
                number
            );

            questionError.classList.add('hidden');

            renderQuestion(
                questionCache[number]
            );

            hideLoading();

            /*
             * Preload next question.
             */
            preloadNext(number);

            return;
        }


        /*
         * First load / uncached question.
         */
        if (isLoading) {
            return;
        }


        isLoading = true;

        showLoading();


        try {

            const data =
                await fetchQuestion(number);


            currentQuestion =
                number;


            sessionStorage.setItem(
                questionStorageKey,
                number
            );


            renderQuestion(data);

            hideLoading();


            /*
             * IMPORTANT:
             *
             * As soon as current question is loaded,
             * next question starts loading in background.
             */
            preloadNext(number);


            /*
             * Also preload previous question.
             */
            preloadPrevious(number);

        }
        catch (error) {

            console.error(
                'Question loading error:',
                error
            );


            questionLoading.classList.add(
                'hidden'
            );

            questionContent.classList.add(
                'hidden'
            );

            questionError.classList.remove(
                'hidden'
            );


            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

        }
        finally {

            isLoading = false;

        }
    }


    /* =========================================================
       PRELOAD NEXT
    ========================================================= */

    function preloadNext(number)
    {
        const next =
            number + 1;


        if (
            next <= totalQuestions &&
            !questionCache[next]
        ) {

            /*
             * No await.
             *
             * Browser background me request karega.
             */
            fetchQuestion(next)
                .catch(error => {

                    console.warn(
                        'Next question preload failed:',
                        error
                    );

                });

        }
    }


    /* =========================================================
       PRELOAD PREVIOUS
    ========================================================= */

    function preloadPrevious(number)
    {
        const previous =
            number - 1;


        if (
            previous >= 1 &&
            !questionCache[previous]
        ) {

            fetchQuestion(previous)
                .catch(error => {

                    console.warn(
                        'Previous question preload failed:',
                        error
                    );

                });

        }
    }


    /* =========================================================
       NEXT QUESTION
    ========================================================= */

    async function nextQuestion()
    {
        if (
            currentQuestion >=
            totalQuestions
        ) {
            return;
        }


        const next =
            currentQuestion + 1;


        /*
         * If preloaded, this is instant.
         */
        if (questionCache[next]) {

            currentQuestion =
                next;

            sessionStorage.setItem(
                questionStorageKey,
                next
            );

            renderQuestion(
                questionCache[next]
            );

            preloadNext(next);

            return;
        }


        /*
         * Very fast fallback if preload
         * has not completed yet.
         */
        await loadQuestion(next);
    }


    /* =========================================================
       PREVIOUS QUESTION
    ========================================================= */

    async function previousQuestion()
    {
        if (
            currentQuestion <= 1
        ) {
            return;
        }


        const previous =
            currentQuestion - 1;


        if (questionCache[previous]) {

            currentQuestion =
                previous;

            sessionStorage.setItem(
                questionStorageKey,
                previous
            );

            renderQuestion(
                questionCache[previous]
            );

            preloadPrevious(previous);

            return;
        }


        await loadQuestion(previous);
    }


    /* =========================================================
       SIDEBAR QUESTION
    ========================================================= */

    async function showQuestion(number)
    {
        if (
            number < 1 ||
            number > totalQuestions
        ) {
            return;
        }


        if (number === currentQuestion) {
            return;
        }


        if (questionCache[number]) {

            currentQuestion =
                number;

            sessionStorage.setItem(
                questionStorageKey,
                number
            );

            renderQuestion(
                questionCache[number]
            );

            preloadNext(number);

            preloadPrevious(number);

            return;
        }


        await loadQuestion(number);
    }


    /* =========================================================
       RETRY
    ========================================================= */

    function retryCurrentQuestion()
    {
        /*
         * Remove failed cache entry if any.
         */
        delete questionCache[
            currentQuestion
        ];


        loadQuestion(
            currentQuestion
        );
    }


    /* =========================================================
       SAVE ANSWER
    ========================================================= */

    async function saveAnswer(
        questionId,
        selectedAnswer,
        number
    ) {

        try {

            const response =
                await fetch(
                    saveAnswerUrl,
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },

                        credentials: 'same-origin',

                        body: JSON.stringify({
                            question_id: questionId,
                            selected_answer: selectedAnswer
                        })
                    }
                );


            if (!response.ok) {

                throw new Error(
                    'Answer save failed.'
                );

            }


            const data =
                await response.json();


            /*
             * Update cached question answer.
             */
            if (questionCache[number]) {

                questionCache[number]
                    .selected_answer =
                    selectedAnswer;

            }


            /*
             * Update sidebar.
             */
            updateQuestionNav(
                number,
                true
            );

        }
        catch (error) {

            console.error(
                'Auto-save error:',
                error
            );

        }
    }


    /* =========================================================
       MARK ANSWERED
    ========================================================= */

    function markAnswered(number)
    {
        updateQuestionNav(
            number,
            true
        );
    }


    /* =========================================================
       SIDEBAR UI
    ========================================================= */

    function updateQuestionNav(
        number,
        answered
    ) {

        document
            .querySelectorAll('.question-nav')
            .forEach(button => {

                const buttonNumber =
                    parseInt(
                        button.textContent.trim()
                    );


                /*
                 * Reset answered styling.
                 */
                button.classList.remove(
                    'border-green-300',
                    'bg-green-100',
                    'text-green-700'
                );


                /*
                 * Current question.
                 */
                if (
                    buttonNumber ===
                    currentQuestion
                ) {

                    button.classList.remove(
                        'border-green-300',
                        'bg-green-100',
                        'text-green-700'
                    );

                    button.classList.add(
                        'border-[#2874b9]',
                        'bg-[#eef6ff]',
                        'text-[#2874b9]'
                    );

                    return;
                }


                /*
                 * Answered question.
                 */
                const cached =
                    questionCache[
                        buttonNumber
                    ];


                if (
                    cached &&
                    cached.selected_answer
                ) {

                    button.classList.add(
                        'border-green-300',
                        'bg-green-100',
                        'text-green-700'
                    );

                }

            });
    }


    /* =========================================================
       NAVIGATION BUTTONS
    ========================================================= */

    function updateNavigationButtons(number)
    {
        previousButton.disabled =
            number <= 1;


        if (
            number >= totalQuestions
        ) {

            nextButton.classList.add(
                'hidden'
            );

        }
        else {

            nextButton.classList.remove(
                'hidden'
            );

        }


        updateQuestionNav(
            number
        );
    }


    /* =========================================================
       TIMER
    ========================================================= */

    function updateTimer()
    {
        if (remainingSeconds <= 0) {

            timer.textContent =
                '00:00';

            timerBox.classList.add(
                'border-red-300',
                'bg-red-50'
            );

            autoSubmitTest();

            return;
        }


        const minutes =
            Math.floor(
                remainingSeconds / 60
            );


        const seconds =
            remainingSeconds % 60;


        timer.textContent =
            String(minutes).padStart(2, '0') +
            ':' +
            String(seconds).padStart(2, '0');


        if (
            remainingSeconds <= 60
        ) {

            timerBox.classList.add(
                'border-red-300',
                'bg-red-50'
            );

            timer.classList.add(
                'text-red-600'
            );

        }


        remainingSeconds--;
    }


    /* =========================================================
       SUBMIT MODAL
    ========================================================= */

    window.openSubmitModal =
        function ()
        {
            const modal =
                document.getElementById(
                    'submitModal'
                );

            modal.classList.remove(
                'hidden'
            );

            modal.classList.add(
                'flex'
            );

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        };


    window.closeSubmitModal =
        function ()
        {
            const modal =
                document.getElementById(
                    'submitModal'
                );

            modal.classList.add(
                'hidden'
            );

            modal.classList.remove(
                'flex'
            );
        };


    /* =========================================================
       SUBMIT
    ========================================================= */

    window.submitTest =
        function ()
        {
            if (isSubmitting) {
                return;
            }


            isSubmitting = true;


            const form =
                document.getElementById(
                    'testForm'
                );


            sessionStorage.removeItem(
                questionStorageKey
            );


            form.submit();
        };


    /* =========================================================
       AUTO SUBMIT
    ========================================================= */

    function autoSubmitTest()
    {
        if (isSubmitting) {
            return;
        }


        isSubmitting = true;


        const form =
            document.getElementById(
                'testForm'
            );


        sessionStorage.removeItem(
            questionStorageKey
        );


        form.submit();
    }


    /* =========================================================
       GLOBAL FUNCTIONS
    ========================================================= */

    window.nextQuestion =
        nextQuestion;

    window.previousQuestion =
        previousQuestion;

    window.showQuestion =
        showQuestion;

    window.retryCurrentQuestion =
        retryCurrentQuestion;


    /* =========================================================
       RESTORE LAST QUESTION
    ========================================================= */

    const savedQuestion =
        sessionStorage.getItem(
            questionStorageKey
        );


    let startQuestion =
        savedQuestion
            ? parseInt(savedQuestion)
            : 1;


    if (
        isNaN(startQuestion) ||
        startQuestion < 1 ||
        startQuestion > totalQuestions
    ) {

        startQuestion = 1;

    }


    /* =========================================================
       INITIAL LOAD
    ========================================================= */

    loadQuestion(
        startQuestion
    );


    /* =========================================================
       TIMER START
    ========================================================= */

    updateTimer();


    setInterval(
        updateTimer,
        1000
    );

});

</script>

@endpush

@endsection
