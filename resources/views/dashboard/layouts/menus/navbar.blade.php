@php
    // $interestsQuery = DB::table('interests')->where('is_read', 0);
    // // Sales users see only their assigned interests
    // if (auth('admin')->user()->type === 'sales') {
    //     $interestsQuery->where('assigned_to', auth('admin')->id());
    // }
    // $unreadInterestsCount = $interestsQuery->count();
@endphp




<nav id="navbar" class="navbar-fixed navbar-main-width">

    <section id="start-of-navbar" class=" d-inline-block">
        <div class=" d-flex align-items-center">
            <div id="btn-aside-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-baseline-density-medium">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 20h16" />
                    <path d="M4 12h16" />
                    <path d="M4 4h16" />
                </svg>
            </div>
        </div>
    </section><!-- start of navbar -->




    <section id="end-of-navbar" class="d-inline-block">



        <div id="notifications" class=" d-inline-block">
            <div class="dropdown-box">
                <a href="{{ route('crm.interests.index') }}" class="btn-toggle dropdown-toggle" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-bell">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                    </svg>

                    <span class="count display-none"></span>

                </a><!-- Button -->
            </div>
        </div>

        <div id="profile" class=" d-inline-block">
            <div class="dropdown-box">
                <a href="{{ adminUrl('profile/edit') }}"
                    title="{{ Str::limit(adminAuth('f_name') . ' ' . adminAuth('l_name'), 20, '') }}"
                    class="btn-toggle dropdown-toggle" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 256 256">
                        <rect width="256" height="256" fill="none" />
                        <circle cx="128" cy="96" r="64" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="24" />
                        <path d="M32,216c19.37-33.47,54.55-56,96-56s76.63,22.53,96,56" fill="none"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24" />
                    </svg>
                </a><!-- Button -->
            </div>
        </div>

    </section><!-- end of navbar -->

</nav><!-- NavBar -->
