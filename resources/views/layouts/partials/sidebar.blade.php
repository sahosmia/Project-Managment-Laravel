<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0">
    <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
        class="flex items-center gap-2 pt-8 sidebar-header pb-7">
        {{-- Using direct URL for href since request()->is() checks paths --}}
        <a href="/dashboard">
            <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                <img class="dark:hidden w-36 flex items-center justify-center"
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSor28R4NlTk5A2Vr3zfgi3FnldWQCm6YgOZQ&s"
                    alt="Logo" />
                <img class="hidden dark:block" src="https://via.placeholder.com/1f2937/d1d5db?text=Dark+Logo"
                    alt="Logo" />
            </span>

            <img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Green_University_of_Bangladesh_logo.svg/1200px-Green_University_of_Bangladesh_logo.svg.png"
                alt="Logo Icon" />
        </a>
        <button @click="sidebarToggle = !sidebarToggle"
            class="lg:hidden p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i :class="sidebarToggle ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'"></i>
        </button>
    </div>
    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <nav
            x-data="{ selected: '{{ request()->is('projects*') ? 'Projects' : (request()->is('users*') ? 'Users' : (request()->is('dashboard') ? 'Dashboard' : (request()->is('departments') ? 'Department' : (request()->is('r_cells') ? 'R-Cell' : (request()->is('proposal-sends') ? 'Proposal-Send' : ''))))) }}' }">
            <div>


                <ul class="flex flex-col gap-4 mb-6">

                    <li>
                        <a href="/dashboard" @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
                            class="menu-item group" :class="(selected === 'Dashboard') || {{ request()->is('dashboard') ? 'true' : 'false' }} ?
                                'menu-item-active' : 'menu-item-inactive'">
                            <i :class="((selected === 'Dashboard') || {{ request()->is('dashboard*') ? 'true' : 'false' }}) ?
                            'menu-item-icon-active' : 'menu-item-icon-inactive'" class="fa-solid fa-chart-line"></i>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    @if (auth()->user()->role == 'admin')
                    <li>
                        <a href="/departments" @click="selected = (selected === 'Department' ? '':'Department')"
                            class="menu-item group" :class="(selected === 'Department') || {{ request()->is('departments') ? 'true' : 'false' }} ?
                                    'menu-item-active' : 'menu-item-inactive'">
                            <i :class="((selected === 'Department') || {{ request()->is('departments') ? 'true' : 'false' }}) ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'" class="fa-solid fa-book"></i>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Department
                            </span>
                        </a>
                    </li>
                    @endif
                    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'supervisor')
                    <li>
                        <a href="{{ route('industrial-proposals.index') }}"
                            @click="selected = (selected === 'Industrial-Proposals' ? '':'Industrial-Proposals')"
                            class="menu-item group" :class="(selected === 'Industrial-Proposals') ||
                                {{ request()->is('industrial-proposals') ? 'true' : 'false' }} ?
                                    'menu-item-active' : 'menu-item-inactive'">
                            <i :class="((selected === 'Industrial-Proposals') ||
                                    {{ request()->is('industrial-proposals') ? 'true' : 'false' }}) ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'" class="fa-solid fa-industry"></i>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Industrial Proposals
                            </span>
                        </a>
                    </li>
                    @endif
                    @if (auth()->user()->role == 'student')
                    <li>
                        <a href="{{ route('industrial-proposals.create') }}"
                            @click="selected = (selected === 'Industrial-Proposal-Send' ? '':'Industrial-Proposal-Send')"
                            class="menu-item group" :class="(selected === 'Industrial-Proposal-Send') ||
                                {{ request()->is('industrial-proposals/create') ? 'true' : 'false' }} ?
                                    'menu-item-active' : 'menu-item-inactive'">
                            <i :class="((selected === 'Industrial-Proposal-Send') ||
                                    {{ request()->is('industrial-proposals/create') ? 'true' : 'false' }}) ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'" class="fa-solid fa-industry"></i>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Industrial Proposal
                            </span>
                        </a>
                    </li>
                    @endif
                    @if (auth()->user()->role == 'admin')
                    <li>
                        <a href="/companies" @click="selected = (selected === 'Company' ? '':'Company')"
                            class="menu-item group" :class="(selected === 'Company') || {{ request()->is('companies') ? 'true' : 'false' }} ?
                                    'menu-item-active' : 'menu-item-inactive'">
                            <i :class="((selected === 'Company') || {{ request()->is('companies') ? 'true' : 'false' }}) ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'" class="fa-solid fa-building"></i>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Company
                            </span>
                        </a>
                    </li>
                    @endif

                    @if (auth()->user()->role == 'admin')
                    <li>
                        <a href="/r_cells" @click="selected = (selected === 'R-Cell' ? '':'R-Cell')"
                            class="menu-item group" :class="(selected === 'R-Cell') || {{ request()->is('r_cells') ? 'true' : 'false' }} ?
                                    'menu-item-active' : 'menu-item-inactive'">
                            <i :class="((selected === 'R-Cell') || {{ request()->is('r_cells') ? 'true' : 'false' }}) ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'"
                                class="fa-solid fa-microscope"></i>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                R-Cell
                            </span>
                        </a>
                    </li>
                    @endif

                    @if (auth()->user()->role == 'student')
                    <li>
                        <a href="/proposal-sends"
                            @click="selected = (selected === 'Proposal-Send' ? '':'Proposal-Send')"
                            class="menu-item group" :class="(selected === 'Proposal-Send') ||
                                {{ request()->is('proposal-sends') ? 'true' : 'false' }} ?
                                    'menu-item-active' : 'menu-item-inactive'">
                            <i :class="((selected === 'Proposal-Send') ||
                                    {{ request()->is('proposal-sends') ? 'true' : 'false' }}) ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'" class="fa-solid fa-seedling"></i>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Proposal Send
                            </span>
                        </a>
                    </li>
                    @endif

                    <li>
                        <a href="#" @click.prevent="selected = (selected === 'Projects' ? '':'Projects')"
                            class="menu-item group" :class="(selected === 'Projects') || {{ request()->is('projects*') ? 'true' : 'false' }} ?
                                'menu-item-active' : 'menu-item-inactive'">
                            <i :class="((selected === 'Projects') || {{ request()->is('projects*') ? 'true' : 'false' }}) ?
                            'menu-item-icon-active' : 'menu-item-icon-inactive'" class="fa-solid fa-table"></i>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Proposal
                            </span>

                            <i :class="[(selected === 'Projects') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive',
                                sidebarToggle ? 'lg:hidden' : ''
                            ]" class="fa-solid fa-angle-down menu-item-arrow"></i>
                        </a>

                        <div class="overflow-hidden transform translate"
                            :class="(selected === 'Projects') ? 'block' : 'hidden'">
                            <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                <li>
                                    <a href="/projects" class="menu-dropdown-item group" :class="{{ request()->is('projects') ? 'true' : 'false' }} ?
                                            'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                        Proposal List </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    @if (auth()->user()->role == 'admin')
                    <li>
                        <a href="#" @click.prevent="selected = (selected === 'Users' ? '':'Users')"
                            class="menu-item group" :class="(selected === 'Users') || {{ request()->is('users*') ? 'true' : 'false' }} ?
                                    'menu-item-active' : 'menu-item-inactive'">
                            <i :class="((selected === 'Users') || {{ request()->is('users*') ? 'true' : 'false' }}) ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'" class="fa-solid fa-users"></i>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Users
                            </span>

                            <i :class="[(selected === 'Users') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive',
                                    sidebarToggle ? 'lg:hidden' : ''
                                ]" class="fa-solid fa-angle-down menu-item-arrow"></i>
                        </a>

                        <div class="overflow-hidden transform translate"
                            :class="(selected === 'Users') ? 'block' : 'hidden'">
                            <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                <li>
                                    <a href="/users" class="menu-dropdown-item group" :class="{{ request()->is('users') ? 'true' : 'false' }} ?
                                                'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                        User List </a>
                                </li>
                                <li>
                                    <a href="/users/create"
                                        class="menu-dropdown-item group {{ request()->is('users/create') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                        User Create
                                    </a>
                                </li>
                               
                            </ul>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</aside>
