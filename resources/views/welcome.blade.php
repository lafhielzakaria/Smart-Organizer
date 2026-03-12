<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Organizer - Shared Local Management Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-slate-900 transition-colors duration-500">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-md z-50 border-b border-gray-200 dark:border-gray-800 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-blue-600 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-xl font-bold text-gray-900 dark:text-white transition-colors duration-500">Smart Organizer</span>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="theme-toggle" type="button" class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 transition-all duration-500 transform">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5 transition-all duration-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 transition-all duration-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-500">Login</a>
                        <a href="{{ route('register') }}" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all duration-500">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 px-4 transition-colors duration-500">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6 transition-colors duration-500">
                Share Locals,<br>
                <span class="text-blue-600 transition-colors duration-500">Split Costs Smartly</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto transition-colors duration-500">
                Smart Organizer helps you book sports fields, study rooms, and coworking spaces collaboratively. Join groups, divide costs fairly, and optimize space usage with our intelligent reservation system.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-4 text-lg font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all duration-500 shadow-lg">
                    Start Organizing
                </a>
                <a href="#features" class="px-8 py-4 text-lg font-semibold text-blue-600 bg-white dark:bg-gray-800 dark:text-blue-400 rounded-lg hover:shadow-lg transition-all duration-500 border border-blue-600">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <section id="features" class="py-20 px-4 bg-white dark:bg-gray-900 transition-colors duration-500">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-16 transition-colors duration-500">Key Features</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 rounded-xl transition-colors duration-500">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-4 transition-colors duration-500">
                        <svg class="w-6 h-6 text-white transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 transition-colors duration-500">Collaborative Booking</h3>
                    <p class="text-gray-600 dark:text-gray-300 transition-colors duration-500">Create or join group reservations. Share costs automatically with participants and optimize space usage.</p>
                </div>

                <div class="p-6 bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-700 rounded-xl transition-colors duration-500">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-4 transition-colors duration-500">
                        <svg class="w-6 h-6 text-white transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 transition-colors duration-500">Points System</h3>
                    <p class="text-gray-600 dark:text-gray-300 transition-colors duration-500">Internal currency for seamless transactions. Members get 50% discount on all reservations.</p>
                </div>

                <div class="p-6 bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-700 rounded-xl transition-colors duration-500">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-4 transition-colors duration-500">
                        <svg class="w-6 h-6 text-white transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 transition-colors duration-500">Smart Analytics</h3>
                    <p class="text-gray-600 dark:text-gray-300 transition-colors duration-500">Track user interest and optimize offerings. Real-time availability dashboard for better decisions.</p>
                </div>

                <div class="p-6 bg-gradient-to-br from-orange-50 to-red-50 dark:from-gray-800 dark:to-gray-700 rounded-xl transition-colors duration-500">
                    <div class="w-12 h-12 bg-orange-600 rounded-lg flex items-center justify-center mb-4 transition-colors duration-500">
                        <svg class="w-6 h-6 text-white transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 transition-colors duration-500">Group Chat</h3>
                    <p class="text-gray-600 dark:text-gray-300 transition-colors duration-500">Coordinate with participants through dedicated chat rooms for each reservation.</p>
                </div>

                <div class="p-6 bg-gradient-to-br from-yellow-50 to-amber-50 dark:from-gray-800 dark:to-gray-700 rounded-xl transition-colors duration-500">
                    <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center mb-4 transition-colors duration-500">
                        <svg class="w-6 h-6 text-white transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 transition-colors duration-500">Advanced Search</h3>
                    <p class="text-gray-600 dark:text-gray-300 transition-colors duration-500">Filter by city, type, and capacity. Find the perfect space quickly and easily.</p>
                </div>

                <div class="p-6 bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-gray-800 dark:to-gray-700 rounded-xl transition-colors duration-500">
                    <div class="w-12 h-12 bg-cyan-600 rounded-lg flex items-center justify-center mb-4 transition-colors duration-500">
                        <svg class="w-6 h-6 text-white transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 transition-colors duration-500">Social Network</h3>
                    <p class="text-gray-600 dark:text-gray-300 transition-colors duration-500">Build your network, add friends, and transfer points between users seamlessly.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 px-4 transition-colors duration-500">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-16 transition-colors duration-500">Who Can Use Smart Organizer?</h2>
            <div class="grid md:grid-cols-4 gap-6">
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg transition-colors duration-500">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors duration-500">
                        <svg class="w-8 h-8 text-red-600 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 transition-colors duration-500">Admin</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 transition-colors duration-500">Manage users and view analytics</p>
                </div>

                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg transition-colors duration-500">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors duration-500">
                        <svg class="w-8 h-8 text-blue-600 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 transition-colors duration-500">Tenant</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 transition-colors duration-500">Manage reservation offers</p>
                </div>

                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg transition-colors duration-500">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors duration-500">
                        <svg class="w-8 h-8 text-green-600 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 transition-colors duration-500">Lessor</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 transition-colors duration-500">Join groups and book spaces</p>
                </div>

                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg transition-colors duration-500">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors duration-500">
                        <svg class="w-8 h-8 text-purple-600 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 transition-colors duration-500">Member</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 transition-colors duration-500">Get 50% discount on all bookings</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 transition-colors duration-500">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-white mb-6 transition-colors duration-500">Ready to Start Organizing?</h2>
            <p class="text-xl text-blue-100 mb-8 transition-colors duration-500">Join thousands of users who are already sharing locals and saving money.</p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-4 text-lg font-semibold text-blue-600 bg-white rounded-lg hover:bg-gray-100 transition-all duration-500 shadow-lg">
                Create Free Account
            </a>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-300 py-12 px-4 transition-colors duration-500">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <svg class="w-8 h-8 text-blue-500 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="text-xl font-bold text-white transition-colors duration-500">Smart Organizer</span>
            </div>
            <p class="text-sm transition-colors duration-500">&copy; {{ date('Y') }} Smart Organizer. All rights reserved.</p>
            <p class="text-sm mt-2 transition-colors duration-500">Share Locals. Split Costs. Organize Smartly.</p>
        </div>
    </footer>
</body>
</html>
