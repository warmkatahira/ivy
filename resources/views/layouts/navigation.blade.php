<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="mx-5">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <span class="align-middle text-lg">
                            <i class="las la-home la-lg align-middle"></i>
                            ホーム
                        </span>
                    </x-nav-link>
                    <x-nav-link :href="route('inventory.top')" :active="request()->routeIs('inventory.top')">
                        <span class="align-middle text-lg">
                            <i class="las la-tasks la-lg align-middle"></i>
                            棚卸
                        </span>
                    </x-nav-link>
                    <x-nav-link :href="route('data.top')" :active="request()->routeIs('data.top')">
                        <span class="align-middle text-lg">
                            <i class="las la-database la-lg align-middle"></i>
                            データ
                        </span>
                    </x-nav-link>
                    <x-nav-link :href="route('maintenance.top')" :active="request()->routeIs('maintenance.top')">
                        <span class="align-middle text-lg">
                            <i class="las la-tools la-lg align-middle"></i>
                            メンテナンス
                        </span>
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                ログアウト
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <span class="align-middle text-lg">
                        <i class="las la-home la-lg"></i>
                        ホーム
                    </span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inventory.top')" :active="request()->routeIs('inventory.top')">
                    <span class="align-middle text-lg">
                        <i class="las la-tasks la-lg"></i>
                        棚卸
                    </span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('data.top')" :active="request()->routeIs('data.top')">
                    <span class="align-middle text-lg">
                        <i class="las la-database la-lg"></i>
                        データ
                    </span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('maintenance.top')" :active="request()->routeIs('maintenance.top')">
                    <span class="align-middle text-lg">
                        <i class="las la-tools la-lg"></i>
                        メンテナンス
                    </span>
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <span class="text-lg">
                            <i class="las la-sign-out-alt la-lg"></i>
                            ログアウト
                        </span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
