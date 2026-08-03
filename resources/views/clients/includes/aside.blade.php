<div class="col-lg-3 col-md-12 mb-4">
    <div class="aside-sticky-top">
        <div class="box">

            <ul id="user-account-aside" class=" mb-0">

                <li class="{{ url()->current() == clientUrl('') ? 'active' : '' }}">
                    <a href="{{ clientUrl('') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-layout-dashboard">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                            <path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                            <path d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1" />
                            <path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1" />
                        </svg>
                        {{ __('client.aside.account_overview') }}
                    </a>
                </li><!-- Dashboard -->


                <li class="{{ url()->current() == clientUrl('owner-associations') ? 'active' : '' }}">
                    <a href="{{ clientUrl('owner-associations') }}" class=" middle-with-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#none" stroke="currentColor">
                            <path
                                d="M240-320q-33 0-56.5-23.5T160-400q0-33 23.5-56.5T240-480q33 0 56.5 23.5T320-400q0 33-23.5 56.5T240-320Zm480 0q-33 0-56.5-23.5T640-400q0-33 23.5-56.5T720-480q33 0 56.5 23.5T800-400q0 33-23.5 56.5T720-320Zm-240-40q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM284-120q14-69 68.5-114.5T480-280q73 0 127.5 45.5T676-120H284Zm-204 0q0-66 47-113t113-47q17 0 32 3t29 9q-30 29-50 66.5T224-120H80Zm656 0q-7-44-27-81.5T659-268q14-6 29-9t32-3q66 0 113 47t47 113H736ZM88-480l-48-64 440-336 160 122v-82h120v174l160 122-48 64-392-299L88-480Z">
                            </path>
                        </svg>
                        <span>{{ __('client.owner_associations.title') }}</span>
                    </a>
                </li><!-- end owner-associations -->

                <li class="{{ url()->current() == clientUrl('owner-associations/requests/no-selection/create') ? 'active' : '' }}">
                    <a href="{{ clientUrl('owner-associations/requests/no-selection/create') }}" class=" middle-with-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                            <path d="M12 11l0 6" />
                            <path d="M9 14l6 0" />
                        </svg>
                        <span>{{ __('client.aside.owner_associations_request') }}</span>
                    </a>
                </li><!-- end owner-associations -->

                <li class="{{ url()->current() == clientUrl('owner-association-polls') ? 'active' : '' }}">
                    <a href="{{ clientUrl('owner-association-polls') }}" class=" middle-with-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none" />
                            <path
                                d="M40,200a8,8,0,0,0,13.15,6.12C105.55,162.16,160,160,160,160h40a40,40,0,0,0,0-80H160S105.55,77.84,53.15,33.89A8,8,0,0,0,40,40Z"
                                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="20" />
                            <path d="M156,79.67v121a8,8,0,0,0,3.56,6.65l15,7.33a8,8,0,0,0,12.2-4.72L200,160"
                                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="20" />
                        </svg>
                        <span>{{ __('client.aside.owner_voting') }}</span>
                    </a>
                </li><!-- end owner-association-polls -->


                <li class="{{ url()->current() == clientUrl('interests') ? 'active' : '' }}">
                    <a href="{{ clientUrl('interests') }}" class=" middle-with-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M9 12l2 2l4 -4" />
                        </svg>

                        <span>{{ __('client.aside.interests') }}</span>
                    </a>
                </li><!-- end interests -->

                <li class="{{ url()->current() == clientUrl('deals') ? 'active' : '' }}">
                    <a href="{{ clientUrl('deals') }}" class=" middle-with-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-contract">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 21h-2a3 3 0 0 1 -3 -3v-1h5.5" />
                            <path d="M17 8.5v-3.5a2 2 0 1 1 2 2h-2" />
                            <path d="M19 3h-11a3 3 0 0 0 -3 3v11" />
                            <path d="M9 7h4" />
                            <path d="M9 11h4" />
                            <path d="M18.42 12.61a2.1 2.1 0 0 1 2.97 2.97l-6.39 6.42h-3v-3z" />
                        </svg>
                        <span>{{ __('client.aside.deals') }}</span>
                    </a>
                </li><!-- end deals -->



                {{-- <li class="{{ url()->current() == clientUrl('notifications') ? 'active' : '' }}">
                    <a href="{{ clientUrl('notifications') }}" class=" middle-with-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <path
                                d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.62-16h45.24A24,24,0,0,1,128,216ZM48,184c7.7-13.24,16-43.92,16-80a64,64,0,1,1,128,0c0,36.05,8.28,66.73,16,80Z">
                            </path>
                        </svg>
                        <span>Notifications</span>
                    </a>
                </li> --}}
                <!-- notifications  -->

                {{-- <li class="{{ url()->current() == clientUrl('contact') ? 'active' : '' }}">
                    <a href="{{ clientUrl('contact') }}" class=" middle-with-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <path
                                d="M144.27,45.93a8,8,0,0,1,9.8-5.66,86.22,86.22,0,0,1,61.66,61.66,8,8,0,0,1-5.66,9.8A8.23,8.23,0,0,1,208,112a8,8,0,0,1-7.73-5.94,70.35,70.35,0,0,0-50.33-50.33A8,8,0,0,1,144.27,45.93Zm-2.33,41.8c13.79,3.68,22.65,12.54,26.33,26.33A8,8,0,0,0,176,120a8.23,8.23,0,0,0,2.07-.27,8,8,0,0,0,5.66-9.8c-5.12-19.16-18.5-32.54-37.66-37.66a8,8,0,1,0-4.13,15.46Zm81.94,95.35A56.26,56.26,0,0,1,168,232C88.6,232,24,167.4,24,88A56.26,56.26,0,0,1,72.92,32.12a16,16,0,0,1,16.62,9.52l21.12,47.15,0,.12A16,16,0,0,1,109.39,104c-.18.27-.37.52-.57.77L88,129.45c7.49,15.22,23.41,31,38.83,38.51l24.34-20.71a8.12,8.12,0,0,1,.75-.56,16,16,0,0,1,15.17-1.4l.13.06,47.11,21.11A16,16,0,0,1,223.88,183.08Zm-15.88-2s-.07,0-.11,0h0l-47-21.05-24.35,20.71a8.44,8.44,0,0,1-.74.56,16,16,0,0,1-15.75,1.14c-18.73-9.05-37.4-27.58-46.46-46.11a16,16,0,0,1,1-15.7,6.13,6.13,0,0,1,.57-.77L96,95.15l-21-47a.61.61,0,0,1,0-.12A40.2,40.2,0,0,0,40,88,128.14,128.14,0,0,0,168,216,40.21,40.21,0,0,0,208,181.07Z">
                            </path>
                        </svg>
                        <span>Contact Us</span>
                    </a>
                </li><!-- end --> --}}


                <li class="{{ url()->current() == clientUrl('profile') ? 'active' : '' }}">
                    <a href="{{ clientUrl('profile') }}" class=" middle-with-svg">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-cog">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5" />
                            <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M19.001 15.5v1.5" />
                            <path d="M19.001 21v1.5" />
                            <path d="M22.032 17.25l-1.299 .75" />
                            <path d="M17.27 20l-1.3 .75" />
                            <path d="M15.97 17.25l1.3 .75" />
                            <path d="M20.733 20l1.3 .75" />
                        </svg>

                        <span>{{ __('client.aside.settings') }}</span>
                    </a>
                </li><!-- end settings -->

                {{-- 
                <li class="{{ url()->current() == clientUrl('properties.create') ? 'active' : '' }}">
                    <a href="{{ clientUrl('properties/create') }}" class="middle-with-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-home-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M19 12h2l-9 -9l-9 9h2v7a2 2 0 0 0 2 2h5.5" />
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2" />
                            <path d="M16 19h6" />
                            <path d="M19 16v6" />
                        </svg>
                        <span>{{ __('client.aside.list_your_property') }} (SOON)</span>
                    </a>
                </li>
                 --}}


                <li class="">
                    <form action="{{ route('main.clients.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class=" font-weight-300 middle-with-svg  {{ lang() == 'ar' ? 'text-right pr-3' : 'text-left pl-3' }}  btn-block px-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                <path
                                    d="M120,216a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V40a8,8,0,0,1,8-8h64a8,8,0,0,1,0,16H56V208h56A8,8,0,0,1,120,216Zm109.66-93.66-40-40a8,8,0,0,0-11.32,11.32L204.69,120H112a8,8,0,0,0,0,16h92.69l-26.35,26.34a8,8,0,0,0,11.32,11.32l40-40A8,8,0,0,0,229.66,122.34Z">
                                </path>
                            </svg>
                            <span>{{ __('client.aside.logout') }}</span>
                        </button>
                    </form>
                </li><!-- end -->


            </ul>
        </div>
    </div>
</div>
