// app.js
(async () => {
    const path = '/dashboard/js/app/';

    // List all files you want to auto-load
    const files = [
        'purpose-options.js',
        'tabs-bar.js',
        'assign-admin.js'
    ];

    for (const file of files) {
        try {
            await import(path + file);
        } catch (err) {
            console.error(`Error loading ${file}:`, err);
        }
    }
})();
