<div
    class="bg-gray-800 rounded-xl p-5 shadow-md hover:shadow-xl transition flex flex-col justify-between border border-gray-700">
    <div>
        <div class="flex items-center space-x-4 mb-4">
            <!-- Логотип радиостанции -->
            <img src="{{ Str::startsWith($station->logo, ['http://', 'https://'])
                ? $station->logo
                : (Str::startsWith($station->logo, 'img/')
                    ? asset($station->logo)
                    : asset('storage/' . $station->logo)) }}"
                alt="{{ $station->name }}" class="w-16 h-16 object-contain bg-gray-700 rounded-lg p-1">
            <h2 class="text-xl font-semibold">{{ $station->name }}</h2>
        </div>
    </div>

    <!-- Список каналов/потоков -->
    <div class="space-y-2">
        <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Доступные потоки:</p>
        @foreach ($station->channels as $channel)
            <button onclick="playRadio('{{ $channel->stream_url }}', '{{ $station->name }} ({{ $channel->name }})')"
                class="w-full bg-indigo-600 hover:bg-indigo-500 text-left py-2 px-3 rounded-lg text-sm font-medium flex justify-between items-center transition">
                <span>{{ $channel->name }}</span>
                <span class="text-xs bg-indigo-800 px-2 py-0.5 rounded text-indigo-200">▶ Слушать</span>
            </button>
        @endforeach
    </div>
</div>
