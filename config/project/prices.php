<?php
/**
 * Price filter configuration for the property search system.
 *
 * This file defines two separate price lists:
 *  - "min": The available minimum price options.
 *  - "max": The available maximum price options.
 *
 * These values are used to populate the price dropdown filters in the search page.
 * Keeping the prices in this config file makes it easy to update or adjust them
 * without touching the Blade views or frontend logic.
 */
return [

    // Minimum prices (زي اللي بعتهم بالضبط)
    'min' => [
        0,
        200000,
        225000,
        250000,
        275000,
        300000,
        325000,
        350000,
        400000,
        450000,
        500000,
        550000,
        600000,
        650000,
        700000,
        750000,
        800000,
        900000,
        1000000,
        2000000,
        3000000,
        4000000,
        5000000,
        6000000,
        7000000,
        8000000,
        9000000,
        10000000,
    ],

    // Maximum prices (اللي بعتهم بالضبط)
    'max' => [
        400000,
        450000,
        500000,
        550000,
        600000,
        650000,
        700000,
        750000,
        800000,
        900000,
        1000000,
        2000000,
        3000000,
        4000000,
        5000000,
        6000000,
        7000000,
        8000000,
        9000000,
        10000000,
    ],

];
