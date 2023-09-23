<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('基本スケジュールの登録') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('遊ぶことができる曜日、時間帯を設定してください') }}
        </p>
    </header>

    <form method="post" action="{{ route('schedule.update') }}" class="mt-6 space-y-6">
        @csrf

        <label>日 <input type="checkbox" name="sunday"></label>
        <label>月 <input type="checkbox" name="monday"></label>
        <label>火 <input type="checkbox" name="tuesday"></label>
        <label>水 <input type="checkbox" name="wednesday"></label>
        <label>木 <input type="checkbox" name="thursday"></label>
        <label>金 <input type="checkbox" name="friday" ></label>
        <label>土 <input type="checkbox" name="saturday"></label>
        
        <br>
        <input type="time" name="time_start">  ～  <input type="time" name="time_end">

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'schedule-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>