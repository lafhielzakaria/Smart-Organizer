<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Smart Organizer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-500">
<div class="min-h-screen">

    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-3">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">Smart Organizer</span>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-500">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5 text-gray-800 dark:text-gray-200" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 text-gray-800 dark:text-gray-200" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-500">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Welcome back, {{ $user->name }}</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Here's an overview of your locals and offers</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 transition-colors duration-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">My Locals</p>
                        <p class="text-4xl font-bold text-gray-900 dark:text-white mt-2">{{ $myLocals->count() }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">properties</p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 transition-colors duration-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Offers</p>
                        <p class="text-4xl font-bold text-gray-900 dark:text-white mt-2">{{ $activeOffers }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">of {{ $totalOffers }} total</p>
                    </div>
                    <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                        <svg class="w-7 h-7 text-purple-600 dark:text-purple-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 transition-colors duration-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Participants</p>
                        <p class="text-4xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalParticipants }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">across all offers</p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-600 dark:text-green-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-500 mb-8">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Locals View Time</h3>
                <button id="toggle-view-btn" onclick="toggleViewAll()" class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:underline">View All</button>
            </div>
            <div class="p-6 space-y-4" id="locals-view-time">
                @forelse($topLocals as $item)
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $item['name'] }}</span>
                    <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">{{ $item['total_view_time'] }}</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5">
                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $allLocals->first() && $allLocals->first()['total_view_time'] > 0 ? round(($item['total_view_time'] / $allLocals->first()['total_view_time']) * 100) : 0 }}%"></div>
                </div>
                @empty
                <p class="text-sm text-gray-400 dark:text-gray-500">No view data available.</p>
                @endforelse
            </div>
            <div class="px-6 pb-6 space-y-4 hidden" id="locals-view-all">
                @foreach($allLocals as $item)
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $item['name'] }}</span>
                    <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">{{ $item['total_view_time'] }}</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5">
                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $allLocals->first() && $allLocals->first()['total_view_time'] > 0 ? round(($item['total_view_time'] / $allLocals->first()['total_view_time']) * 100) : 0 }}%"></div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-500 mb-8">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">My Locals</h3>
            </div>
            @forelse($myLocals as $local)
            <div class="p-6 {{ !$loop->last ? 'border-b border-gray-200 dark:border-gray-700' : '' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">{{ $local->name }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                            {{ $local->city }} &bull; {{ ucfirst($local->type) }} &bull; Capacity: {{ $local->capacity }} &bull; {{ $local->price }} pts
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $local->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                            {{ ucfirst($local->status) }}
                        </span>
                        <span class="text-xs text-gray-400 dark:text-gray-500">{{ $local->local_offers_count }} offer(s)</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-16 text-center">
                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-medium">You have no locals yet</p>
            </div>
            @endforelse
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-500">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">My Offers</h3>
            </div>
            @php $allOffers = $myLocals->flatMap(fn($l) => $l->localOffers->each(fn($o) => $o->localName = $l->name)); @endphp
            @if($allOffers->count() > 0)
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach($allOffers as $offer)
                <div class="bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <p class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 mb-0.5">{{ $offer->localName }}</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $offer->startTime->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $offer->startTime->format('H:i') }} → {{ $offer->endTime->format('H:i') }}</p>
                        </div>
                        <span @class(['px-2 py-0.5 text-xs font-medium rounded-full',
                            'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' => $offer->status === 'available',
                            'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' => $offer->status === 'completed',
                            'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' => !in_array($offer->status, ['available', 'completed']),
                        ])>{{ ucfirst($offer->status) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mt-3">
                        <span>{{ $offer->pricePerPerson }} pts/person</span>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $offer->participations_count }} / {{ $offer->maxParticipants }}</span>
                    </div>
                    <div class="mt-2 w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5">
                        <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $offer->maxParticipants > 0 ? round(($offer->participations_count / $offer->maxParticipants) * 100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-16 text-center">
                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-medium">No offers yet</p>
            </div>
            @endif
        </div>

    </div>
</div>
<script>
    function toggleViewAll() {
        const top = document.getElementById('locals-view-time');
        const all = document.getElementById('locals-view-all');
        const btn = document.getElementById('toggle-view-btn');
        const isShowingAll = !all.classList.contains('hidden');
        top.classList.toggle('hidden', !isShowingAll);
        all.classList.toggle('hidden', isShowingAll);
        btn.textContent = isShowingAll ? 'View All' : 'Show Less';
    }
</script>
</body>
</html>
