@php
    /*
    |--------------------------------------------------------------------------
    | Counters (currently disabled)
    |--------------------------------------------------------------------------
    */
    $titles = [
        'interests' => isSalesAdmin() ? 'اهتمامات عملائي' : 'اهتمامات العملاء',
    ];

    //  $interests = DB::table('interests')->where('is_read', '0')->count();
    //  $my_interests = DB::table('interests')->where('action_completed', '0')->where('marketer_id', adminId())->count();

    /*
    |--------------------------------------------------------------------------
    | Sidebar Icons SVG Map
    |--------------------------------------------------------------------------
    */
    $icons = [
        /* ===== Global ===== */
        'plus' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>',

        'mail' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" /><path d="M3 7l9 6l9 -6" /></svg>',

        'dashboard' =>
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M24,176V153.13C24,95.65,70.15,48.2,127.63,48A104,104,0,0,1,232,152v24a8,8,0,0,1-8,8H32A8,8,0,0,1,24,176Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="128" y1="48" x2="128" y2="80" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="104" y1="184" x2="164" y2="100" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="200" y1="136" x2="230.78" y2="136" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="25.39" y1="136" x2="56" y2="136" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/></svg>',

        'interests' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-bell"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>',
        'contracts' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-contract"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 21h-2a3 3 0 0 1 -3 -3v-1h5.5" /><path d="M17 8.5v-3.5a2 2 0 1 1 2 2h-2" /><path d="M19 3h-11a3 3 0 0 0 -3 3v11" /><path d="M9 7h4" /><path d="M9 11h4" /><path d="M18.42 12.61a2.1 2.1 0 0 1 2.97 2.97l-6.39 6.42h-3v-3l6.42 -6.39" /></svg>',
        /* ===== Clients ===== */
        'clients' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>',

        'clients_all' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-group"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" /><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M17 10h2a2 2 0 0 1 2 2v1" /><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M3 13v-1a2 2 0 0 1 2 -2h2" /></svg>',
        /* ===== Deals ===== */
        'deals' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-checklist"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg>',

        'deals_analytics' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chart-pie"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 3.2a9 9 0 1 0 10.8 10.8a1 1 0 0 0 -1 -1h-6.8a2 2 0 0 1 -2 -2v-7a.9 .9 0 0 0 -1 -.8" /><path d="M15 3.5a9 9 0 0 1 5.5 5.5h-4.5a1 1 0 0 1 -1 -1v-4.5" /></svg>',

        'deals_all' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-stack-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 4l-8 4l8 4l8 -4l-8 -4" /><path d="M4 12l8 4l8 -4" /><path d="M4 16l8 4l8 -4" /></svg>',

        /* ===== Location ===== */
        'city' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M7 1.25a.75.75 0 0 1 .75.75v1.75h.295c.433 0 .83 0 1.152.043c.356.048.731.16 1.04.47s.422.684.47 1.04c.043.323.043.72.043 1.152v1.427q.1.079.194.173c.456.456.642 1.023.726 1.65c.058.434.074.95.078 1.545h.502V7.71c0-1.258 0-2.287.116-3.072c.12-.814.387-1.54 1.068-2.012c.68-.472 1.455-.467 2.259-.294c.775.168 1.739.529 2.917.97l.096.037c.595.223 1.1.412 1.495.613c.42.214.785.472 1.06.868c.274.396.388.827.44 1.296c.049.441.049.98.049 1.616V21.25H22a.75.75 0 0 1 0 1.5H2a.75.75 0 0 1 0-1.5h.25v-9.302c0-.899 0-1.648.08-2.242c.084-.628.27-1.195.725-1.65q.095-.095.195-.174V6.455c0-.433 0-.83.043-1.152c.048-.356.16-.731.47-1.04s.684-.422 1.04-.47c.323-.043.72-.043 1.152-.043h.295V2A.75.75 0 0 1 7 1.25M4.75 7.324c.588-.074 1.322-.074 2.198-.074h.104c.876 0 1.61 0 2.198.074V6.5c0-.493-.002-.787-.03-.997a.7.7 0 0 0-.042-.177l-.001-.003l-.003-.001l-.01-.005a.7.7 0 0 0-.167-.037c-.21-.028-.504-.03-.997-.03H6c-.493 0-.787.002-.997.03a.7.7 0 0 0-.177.042l-.003.001l-.001.003l-.005.01a.7.7 0 0 0-.037.167c-.028.21-.03.504-.03.997zm-1 13.926h2.5v-5.302c0-.899 0-1.648.08-2.242c.084-.628.27-1.195.725-1.65c.456-.456 1.023-.642 1.65-.726c.434-.058.948-.074 1.543-.078c-.004-.57-.018-1-.064-1.347c-.063-.461-.17-.659-.3-.789s-.328-.237-.79-.3C8.613 8.753 7.965 8.75 7 8.75s-1.612.002-2.095.067c-.461.062-.659.169-.789.3s-.237.327-.3.788c-.064.483-.066 1.131-.066 2.095zm4 0h8.5V16c0-.964-.002-1.612-.067-2.095c-.062-.461-.169-.659-.3-.789s-.327-.237-.788-.3c-.483-.064-1.131-.066-2.095-.066h-2c-.964 0-1.612.002-2.095.066c-.461.063-.659.17-.789.3s-.237.328-.3.79c-.064.482-.066 1.13-.066 2.094zm10 0h2.5V7.772c0-.687-.001-1.141-.04-1.49c-.037-.33-.1-.49-.183-.608c-.081-.118-.21-.235-.505-.385c-.313-.158-.737-.319-1.38-.56c-1.251-.469-2.11-.79-2.765-.93c-.64-.138-.909-.065-1.089.06c-.18.124-.343.351-.438.998c-.098.662-.1 1.58-.1 2.915v3.48c.595.004 1.111.02 1.544.078c.628.084 1.195.27 1.65.726c.456.455.642 1.022.726 1.65c.08.594.08 1.344.08 2.242zM9.25 15a.75.75 0 0 1 .75-.75h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75m0 3a.75.75 0 0 1 .75-.75h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75" clip-rule="evenodd"/></svg>',
        'area' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-map-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" /><path d="M9 4v13" /><path d="M15 7v5.5" /><path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" /><path d="M19 18v.01" /></svg>',

        /* ===== Properties ===== */
        'property_types' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-home-cog"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 21v-6a2 2 0 0 1 2 -2h1.6" /><path d="M20 11l-8 -8l-9 9h2v7a2 2 0 0 0 2 2h4.159" /><path d="M18 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M18 14.5v1.5" /><path d="M18 20v1.5" /><path d="M21.032 16.25l-1.299 .75" /><path d="M16.27 19l-1.3 .75" /><path d="M14.97 16.25l1.3 .75" /><path d="M19.733 19l1.3 .75" /></svg>',

        'property_facades' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-compass"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 16l2 -6l6 -2l-2 6l-6 2" /><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 3l0 2" /><path d="M12 19l0 2" /><path d="M3 12l2 0" /><path d="M19 12l2 0" /></svg>',

        'properties' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-id-badge-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12h3v4h-3z" /><path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" /><path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M14 16h2" /><path d="M14 12h4" /></svg>',

        'finishing_types' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-paint"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" /><path d="M19 6h1a2 2 0 0 1 2 2a5 5 0 0 1 -5 5l-5 0v2" /><path d="M10 15m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /></svg>',

        'property_features' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3.5 5.5l1.5 1.5l2.5 -2.5" /><path d="M3.5 11.5l1.5 1.5l2.5 -2.5" /><path d="M3.5 17.5l1.5 1.5l2.5 -2.5" /><path d="M11 6l9 0" /><path d="M11 12l9 0" /><path d="M11 18l9 0" /></svg>',
        /* ===== System ===== */
        'system' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-folder-cog"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 19h-7.5a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v3" /><path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19.001 15.5v1.5" /><path d="M19.001 21v1.5" /><path d="M22.032 17.25l-1.299 .75" /><path d="M17.27 20l-1.3 .75" /><path d="M15.97 17.25l1.3 .75" /><path d="M20.733 20l1.3 .75" /></svg>',

        /* ===== Owner Associations ===== */
        'mullak_create' =>
            '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M240-320q-33 0-56.5-23.5T160-400q0-33 23.5-56.5T240-480q33 0 56.5 23.5T320-400q0 33-23.5 56.5T240-320Zm480 0q-33 0-56.5-23.5T640-400q0-33 23.5-56.5T720-480q33 0 56.5 23.5T800-400q0 33-23.5 56.5T720-320Zm-240-40q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM284-120q14-69 68.5-114.5T480-280q73 0 127.5 45.5T676-120H284Zm-204 0q0-66 47-113t113-47q17 0 32 3t29 9q-30 29-50 66.5T224-120H80Zm656 0q-7-44-27-81.5T659-268q14-6 29-9t32-3q66 0 113 47t47 113H736ZM88-480l-48-64 440-336 160 122v-82h120v174l160 122-48 64-392-299L88-480Z"/></svg>',
        /* ===== Global ===== */
        'faqs' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-question-mark"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8a3.5 3 0 0 1 3.5 -3h1a3.5 3 0 0 1 3.5 3a3 3 0 0 1 -2 3a3 4 0 0 0 -2 4" /><path d="M12 19l0 .01" /></svg>',
        'privacy' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text-shield"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 3v4a.997 .997 0 0 0 1 1h4" /><path d="M11 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v3.5" /><path d="M8 9h1" /><path d="M8 12.994l3 0" /><path d="M8 16.997l2 0" /><path d="M21 15.994c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5" /></svg>',
        'roles' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>',
        'pages' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-browser"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8h16" /><path d="M4 6a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2l0 -12" /><path d="M8 4v4" /></svg>',
        'dot' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-point"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 12a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /></svg>',
        'settings' =>
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>',
    ];
@endphp
<aside id="aside">

    {{-- ========================================================= --}}
    {{-- Profile Dropdown --}}
    {{-- ========================================================= --}}
    <div class="btn-group aside-brand">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">

            <div class="d-flex align-items-center">
                <div class="avatar">
                    <img src="{{ asset('assets/images/default/avatar.png') }}">
                </div>

                <div class="name">
                    <h6 class=" text-right">
                        {{ adminAuth('full_name') }}
                        {{-- <span class="badge badge-light font-12 text-capitalize">{{ adminAuth('type') }} </span> --}}
                    </h6>
                    <span>{{ adminAuth('email') }}</span>
                </div>
            </div>

            <div class="icon">
                <i class="fa-solid fa-angle-down"></i>
            </div>
        </button>

        {{-- <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item disabled" href="#">Disabled</a>
        </div> --}}

    </div>


    <ul class="side-menu">


        {{-- ========================================================= --}}
        {{-- General --}}
        {{-- ========================================================= --}}
        <li class="side-item-category">عام</li>

        <x-dashboard.aside :details="[
            'name' => 'لوحة التحكم',
            'icon' => $icons['dashboard'],
            'link' => 'home',
        ]" />

        <x-dashboard.aside :details="[
            'name' =>
                $titles['interests'] .
                '<span class=\'aside-interests-count display-none badge badge-danger text-white float-left\'></span>',
            'icon' => $icons['interests'],
            'link' => 'crm/interests',
            'can' => isSalesAdmin() == false ? 'interests_view_page' : null,
        ]" />


        @php
            $mailbox = [
                'name' => 'صندوق البريد',
                'icon' => $icons['mail'],
                'link' => 'mail',
            ];
        @endphp
        <x-dashboard.aside :details="$mailbox" />
        <!-- End mailbox -->




        {{-- ========================================================= --}}
        {{-- Offers & Properties --}}
        {{-- ========================================================= --}}
        @canany(['properties_create', 'interests_view_page'])

            <li class="side-item-category">العروض والخدمات</li>

            @can('properties_create')
                <li class="side-item">
                    <a data-toggle="modal" data-target="#model-add-property">
                        <span class="side-icon">{!! $icons['plus'] !!}</span>
                        <span class="side-name-lable">اضافة وحدة جديدة</span>
                    </a>
                </li>
            @endcan

            <x-dashboard.aside :details="[
                'name' => 'الوحدات',
                'icon' => $icons['properties'],
                'link' => 'properties',
                'can' => 'interests_view_page',
            ]" />


            <x-dashboard.aside :details="[
                'name' => 'عقود الإيجار',
                'icon' => $icons['contracts'],
                'link' => 'rental/contracts',
                // 'can' => 'interests_view_page',
            ]" />
        @endcanany





        {{-- ========================================================= --}}
        {{-- CRM Section --}}
        {{-- ========================================================= --}}
        @canany(['clients_view_all_page', 'clients_create', 'clients_view_statistics', 'deals_view_all_page',
            'deals_view_statistics', 'deals_view_followups'])
            <li class="side-item-category">إدارة العملاء</li>
        @endcanany

        @canany(['clients_view_all_page', 'clients_view_statistics'])
            <x-dashboard.aside :details="[
                'name' => 'إدارة العملاء',
                'icon' => $icons['clients'],
                'sub_menu' => [
                    [
                        'can' => 'clients_view_all_page',
                        'name' => 'جميع العملاء',
                        'link' => 'crm/clients',
                        'icon' => $icons['clients_all'],
                    ],
                    [
                        'can' => 'clients_create',
                        'name' => 'اضافة عميل جديد',
                        'link' => 'crm/clients/create',
                        'icon' => $icons['plus'],
                    ],
                    [
                        'can' => 'clients_view_statistics',
                        'name' => 'تحليلات العملاء',
                        'link' => 'crm/clients/analytics',
                        'icon' => $icons['deals_analytics'],
                    ],
                ],
            ]" />
        @endcanany

        @if (isSalesAdmin() || admin()?->canAny(['deals_view_all_page', 'deals_view_statistics', 'deals_view_followups']))
            <x-dashboard.aside :details="[
                'name' => 'الصفقات',
                'icon' => $icons['deals'],
                'sub_menu' => [
                    [
                        'can' => !isSalesAdmin() ? 'deals_view_all_page' : null,
                        'name' => 'جميع الصفقات',
                        'link' => 'crm/deals',
                        'icon' => $icons['deals_all'],
                    ],
                    [
                        'can' => 'deals_view_statistics',
                        'name' => 'تحليلات الصفقات',
                        'link' => 'crm/deals/analytics',
                        'icon' => $icons['deals_analytics'],
                    ],
                ],
            ]" />

            <x-dashboard.aside :details="[
                'name' =>
                    'متابعات الصفقات <span class=\'aside-deals-follow-ups-count display-none badge badge-danger text-white float-left\'></span>',
                'icon' => $icons['interests'],
                'link' => 'crm/deals/follow-ups',
                'can' => 'deals_view_followups',
            ]" />
        @endif






        {{-- ========================================================= --}}
        {{-- Owner Associations --}}
        {{-- ========================================================= --}}
        {{-- @if (isSalesAdmin())
            <li class="side-item-category">اتحاد الملاك</li>
        @else
            @canany(['owner_associations_create', 'owner_associations_view_requests_page'])
                <li class="side-item-category">اتحاد الملاك</li>
            @endcanany
        @endif


        @can('owner_associations_create')
            <li class="side-item">
                <a data-toggle="modal" data-target="#model-add-owner-association">
                    <span class="side-icon">{!! $icons['plus'] !!}</span>
                    <span class="side-name-lable">إنشاء اتحاد ملاك</span>
                </a>
            </li>
        @endcan

        <x-dashboard.aside :details="[
            'can' => 'owner_associations_view_requests_page',
            'name' => 'اتحادات الملاك',
            'icon' => $icons['mullak_create'],
            'link' => 'owner-associations',
        ]" />

        <x-dashboard.aside :details="[
            'can' => isSalesAdmin() == false ? 'owner_associations_view_requests_page' : null,
            'name' =>
                'الطلبات & الشكاوي <span class=\'aside-owner-associations-requests-count display-none badge badge-danger text-white float-left\'></span>',
            'icon' => $icons['interests'],
            'link' => 'owner-associations/requests',
        ]" /> --}}



        {{-- ========================================================= --}}
        {{-- System Settings --}}
        {{-- ========================================================= --}}
        @can('admins')
            <li class="side-item-category">مستخدمين النظام</li>
            <x-dashboard.aside :details="[
                'name' => 'المشرفين',
                'icon' => $icons['clients'],
                'link' => 'admins',
            ]" /><!-- End Admins -->
        @endcan

        @can('create_admin')
            <x-dashboard.aside :details="[
                'name' => 'اضافة مشرف جديد',
                'icon' => $icons['plus'],
                'link' => 'admins/create',
            ]" /><!-- End Admins -->
        @endcan

        @role(owner())
            <x-dashboard.aside :details="[
                'name' => 'الأدوار & الصلاحيات',
                'icon' => $icons['roles'],
                'link' => 'roles',
            ]" /><!-- End roles -->
        @endrole







        {{-- ========================================================= --}}
        {{-- System Settings --}}
        {{-- ========================================================= --}}
        <li class="side-item-category">النظام</li>

        @canany(['city_view', 'neighborhood_view', 'property_types_view', 'property_facades_view',
            'property_furnishing_view', 'property_features_view', 'property_amenities_view'])
            <x-dashboard.aside :details="[
                'name' => 'بيانات النظام',
                'icon' => $icons['system'],
                'sub_menu' => [
                    [
                        'can' => 'city_view', //
                        'name' => 'المدن',
                        'link' => 'cities',
                        'icon' => $icons['city'],
                    ],
                    [
                        'can' => 'neighborhood_view', //
                        'name' => 'الأحياء',
                        'link' => 'neighborhoods',
                        'icon' => $icons['area'],
                    ],
                    [
                        'can' => 'property_types_view',
                        'name' => 'أنواع الوحدات',
                        'link' => 'properties/types',
                        'icon' => $icons['property_types'],
                    ],
                    [
                        'can' => 'property_facades_view',
                        'name' => 'واجهات الوحدات',
                        'link' => 'properties/facades',
                        'icon' => $icons['property_facades'],
                    ],
                    [
                        'can' => 'property_furnishing_view', //
                        'name' => 'أنواع التشطيب',
                        'link' => 'properties/finishing-types',
                        'icon' => $icons['finishing_types'],
                    ],
                    [
                        'can' => 'property_features_view', //
                        'name' => 'مميزات الوحدات',
                        'link' => 'properties/features',
                        'icon' => $icons['property_features'],
                    ],
                    [
                        'can' => 'property_amenities_view', //
                        'name' => 'مرافق الوحدات',
                        'link' => 'properties/amenities',
                        'icon' => $icons['property_features'],
                    ],
                ],
            ]" />
        @endcanany



        <x-dashboard.aside :details="[
            'name' => 'الإعدادات',
            'icon' => $icons['settings'],
            'sub_menu' => [
                [
                    'can' => '',
                    'name' => 'الإعدادات العامة',
                    'link' => 'settings/general',
                    'icon' => $icons['dot'],
                ], //
            ],
        ]" /><!--  -->

        <x-dashboard.aside :details="[
            'name' => 'الصفحات',
            'icon' => $icons['pages'],
            'sub_menu' => [
                //    [
                //         'can' => '',
                //         'name' => 'من نحن',
                //         'link' => 'pages/about',
                //         'icon' => $icons['dot'],
                //     ], // faqs
                [
                    'can' => '',
                    'name' => 'الصفحة الرئيسية',
                    'link' => 'pages/home',
                    'icon' => $icons['dot'],
                ], //
                [
                    'can' => '',
                    'name' => 'الأسئلة الشائعة',
                    'link' => 'faqs',
                    'icon' => $icons['faqs'],
                ], // faqs
                [
                    'can' => '',
                    'name' => 'سياسة الخصوصية',
                    'link' => 'privacy',
                    'icon' => $icons['privacy'],
                ], // privacy
            ],
        ]" />


        {{-- ========================================================= --}}
        {{-- External Site --}}
        {{-- ========================================================= --}}
        <li class="side-item">
            <a target="__blank" href="{{ url('') }}">
                <span class="side-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-world">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                        <path d="M3.6 9h16.8" />
                        <path d="M3.6 15h16.8" />
                        <path d="M11.5 3a17 17 0 0 0 0 18" />
                        <path d="M12.5 3a17 17 0 0 1 0 18" />
                    </svg>
                </span>
                <span class="side-name-lable">زيارة الموقع</span>
            </a>
        </li>





        {{-- ========================================================= --}}
        {{-- Logout --}}
        {{-- ========================================================= --}}
        <li class="side-item mb-5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class=" w-100 d-block text-right">
                    <a class="">
                        <span class="side-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path d="M9 12h12l-3 -3" />
                                <path d="M18 15l3 -3" />
                            </svg>
                        </span>
                        <span class="side-name-lable">تسجيل الخروج</span>
                    </a>
                </button>
            </form>
        </li>



    </ul>
    {{-- 
    <a style="font-size: 15px;position: absolute;bottom: 15px;left: 30%;" class="text-secondary"
        href="https://salehmegawer.com/" target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M5 12l14 0" />
            <path d="M13 18l6 -6" />
            <path d="M13 6l6 6" />
        </svg>
        By Saleh Megawer
    </a> --}}

</aside>

<div class="aside-overlay"></div>
