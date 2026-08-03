<?php

use App\Models\Property\Property;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * --------------------------------------------------------------
 *  File Overview (Helper Functions Map)
 * --------------------------------------------------------------
 *  - bootstrapColors()        : Returns predefined Bootstrap color palette.
 *  - getAuth()                : Fetch authenticated user information for a given guard.
 *  - alert()                  : Renders a styled Bootstrap alert message.
 *  - parseTime()              : Human-readable time formatting using Carbon.
 *  - activeLink()             : Determines active navigation state for Blade views.
 *  - getVal()                 : Safely extract a column value from a model/array.
 *  - currency_icon()          : Load SAR currency icon as inline SVG.
 *  - getIdFromSlug()          : Extract record ID from dynamic slug URL.
 *  - propertyImage()          : Returns property image path with size handling.
 *  - propertyUrl()            : Returns property URL based on slug and ID with language support.
 *  - normalizeArabic()        : Normalize & clean Arabic text for search or comparison.
 *  - languages()              : Retrieve supported languages from config.
 *  - countriesData()          : List of Middle Eastern & Arab countries with dial codes.
 *  - phoneNumberLengths()     : Required phone number length per country code.
 *  - phoneNumberFormats()     : Example phone number patterns per country.
 *  - appUrl()                 : Return url with lang
 *  - log_field()              : Return Log Field From Class \App\Helpers\LogFields
 *  - urlSwitchLang()          : Switch current URL language segment between "ar" and "en"
 *  - msg()                    : Translate message key from resources/lang/{locale}/messages.php
 * --------------------------------------------------------------
 */

/**
 * Returns a list of Bootstrap color classes used throughout the UI.
 */
function bootstrapColors()
{
    return ['danger', 'primary', 'success', 'secondary', 'warning', 'info', 'light', 'dark'];
}

/**
 * Retrieve authenticated user data for a specific guard.
 *
 * @param string $guard
 * @param string $get
 * @return mixed|null
 */
function getAuth($guard, $get)
{
    if (Auth::guard($guard)->check()) {
        return auth($guard)->user()->$get;
    }
    return null;
}

/**
 * Render a styled Bootstrap alert box.
 * Validates color before output.
 *
 * @param string $message
 * @param string $color
 */
function alert($message, $color = 'info')
{
    if (in_array($color, bootstrapColors())) {
        echo "<div class='text-center alert alert-{$color}'>{$message}</div>";
    } else {
        echo '<div class="container"><div class="row">';
        echo "<div class='col-12 mb-3'><h6>This Color (<b class='text-danger'>{$color}</b>) Does Not Exist. Choose from the palette below:</h6></div>";

        foreach (bootstrapColors() as $co) {
            echo "<div class='col'><div class='alert alert-{$co} p-2 rounded'>{$co}</div></div>";
        }

        echo '</div></div>';
    }
}

/**
 * Convert a datetime string into a human readable format.
 *
 * @param string|null $time
 * @return string
 */
function parseTime($time = null)
{
    return Carbon::parse($time ?? date('Y-m-d h:i:s'))->diffForHumans();
}

/**
 * Determine active class for Blade navigation items.
 *
 * @param string $url
 * @param string $setClassName
 * @return string|false
 */
function activeLink($url, $setClassName = 'active')
{
    return request()->path() === $url ? $setClassName : false;
}

/**
 * Safely return a value from a database row.
 *
 * @param mixed $dbRow
 * @param string $column
 * @return mixed|null
 */
function getVal($dbRow, string $column)
{
    return empty($dbRow) ? null : $dbRow[$column];
}

if (! function_exists('currency_icon')) {
    /**
     * @param $size allowed ( md , sm , xs )
     */
    function currency_icon($size = 'md', $fill = '#000')
    {

        return "<span class='{$size}-currency-text'>ج.م</span>";

        $svg = file_get_contents(public_path('dashboard/images/sar.svg'));

        $svg = preg_replace(
            '/<svg\b/',
            '<svg fill="'.$fill.'"',
            $svg,
            1
        );

        return "<span class='{$size}-currency-icon-svg'>{$svg}</span>";
    }
}

/**
 * Extract ID from slug format.
 *
 * @param string $slug
 * @return string
 */
function getIdFromSlug($slug)
{
    return Str::of($slug)->explode('-')->last();
}

/**
 * Return property image based on size or fallback to default.
 *
 * @param string|null $imgName
 * @param string $size
 * @return string
 */
function propertyImage($imgName, $size = 'small')
{
    $default_image = asset('assets/images/default/properties.png');

    if ($imgName) {
        $size = in_array($size, ['large', 'medium', 'small']) ? $size : 'small';

        $path = Property::PATH . '/' . $imgName;

        $sizePaths = [
            'large'  => largePath($path),
            'medium' => mediumPath($path),
            'small'  => smallPath($path),
        ];

        $sizeAssets = [
            'large'  => largeAsset($path),
            'medium' => mediumAsset($path),
            'small'  => smallAsset($path),
        ];

        return file_exists($sizePaths[$size]) ? $sizeAssets[$size] : $default_image;

    }
    return $default_image;
}

/**
 * Generate property URL using unified slug structure.
 *
 * This helper wraps slugUrl() to keep property links consistent
 * across the application and allow future changes from one place
 * (e.g. slug source, ID vs UUID, language handling).
 *
 * @param  object  $property   Property model instance
 * @return string
 */
function propertyUrl($property): string
{
    return slugUrl(
        'property',
        $property->title,
        $property->id,
        true
    );
}

/**
 * Normalize Arabic text for search & filtering.
 *
 * @param string $text
 * @param bool $removeStopwords
 * @return string
 */
function normalizeArabic($text, $removeStopwords = true)
{
    if (! $text) {
        return $text;
    }

    $map = [
        'أ' => 'ا', 'إ' => 'ا', 'آ' => 'ا', 'ٱ' => 'ا',
        'ى' => 'ي', 'ئ' => 'ي', 'ؤ' => 'و',
        'ة' => 'ه',
        'ٮ' => 'ي', 'ے' => 'ي', 'ؽ' => 'ي', 'ؾ' => 'ي', 'ؿ' => 'ي',
    ];

    $text = strtr($text, $map);
    $text = preg_replace('/[ـ\p{Mn}]/u', '', $text);
    $text = preg_replace('/[^ء-يa-zA-Z0-9\s]/u', ' ', $text);

    $text = mb_strtolower($text, 'UTF-8');
    $text = trim(preg_replace('/\s+/', ' ', $text));

    if ($removeStopwords) {
        $stopwords = array_flip(config('stopwords', []));
        $words     = explode(' ', $text);

        $words = array_filter($words, function ($word) use ($stopwords) {
            $baseWord = $word;

            if (mb_strlen($word, 'UTF-8') > 2) {
                $baseWord = preg_replace('/^(و|ف|ب|ك|ل)/u', '', $baseWord);
            }

            $baseWord = preg_replace('/^ال/u', '', $baseWord);

            return $baseWord !== '' && ! isset($stopwords[$baseWord]);
        });

        $text = implode(' ', $words);
    }

    return $text;
}

/**
 * Return all languages from config/locales.php
 */
if (! function_exists("languages")) {
    function languages()
    {
        return config('languages.languages');
    }
}

/**
 * Countries list with codes and flags.
 */
if (! function_exists('countriesData')) {
    function countriesData()
    {
        return [
            ['name_en' => 'Egypt', 'name_ar' => 'مصر', 'code' => '+20', 'flag' => 'https://flagcdn.com/w320/eg.png'],
            ['name_en' => 'Saudi Arabia', 'name_ar' => 'السعودية', 'code' => '+966', 'flag' => 'https://flagcdn.com/w320/sa.png'],
            ['name_en' => 'United Arab Emirates', 'name_ar' => 'الإمارات', 'code' => '+971', 'flag' => 'https://flagcdn.com/w320/ae.png'],
            ['name_en' => 'Kuwait', 'name_ar' => 'الكويت', 'code' => '+965', 'flag' => 'https://flagcdn.com/w320/kw.png'],
            ['name_en' => 'Qatar', 'name_ar' => 'قطر', 'code' => '+974', 'flag' => 'https://flagcdn.com/w320/qa.png'],
            ['name_en' => 'Jordan', 'name_ar' => 'الأردن', 'code' => '+962', 'flag' => 'https://flagcdn.com/w320/jo.png'],
            //  ['name_en' => 'Oman', 'name_ar' => 'عُمان', 'code' => '+968', 'flag' => 'https://flagcdn.com/w320/om.png'],
            //  ['name_en' => 'Bahrain', 'name_ar' => 'البحرين', 'code' => '+973', 'flag' => 'https://flagcdn.com/w320/bh.png'],
            //  ['name_en' => 'Lebanon', 'name_ar' => 'لبنان', 'code' => '+961', 'flag' => 'https://flagcdn.com/w320/lb.png'],
            //   ['name_en' => 'Syria', 'name_ar' => 'سوريا', 'code' => '+963', 'flag' => 'https://flagcdn.com/w320/sy.png'],
            //  ['name_en' => 'Iraq', 'name_ar' => 'العراق', 'code' => '+964', 'flag' => 'https://flagcdn.com/w320/iq.png'],
            // ['name_en' => 'Morocco', 'name_ar' => 'المغرب', 'code' => '+212', 'flag' => 'https://flagcdn.com/w320/ma.png'],
            // ['name_en' => 'Algeria', 'name_ar' => 'الجزائر', 'code' => '+213', 'flag' => 'https://flagcdn.com/w320/dz.png'],
            // ['name_en' => 'Tunisia', 'name_ar' => 'تونس', 'code' => '+216', 'flag' => 'https://flagcdn.com/w320/tn.png'],
            // ['name_en' => 'Libya', 'name_ar' => 'ليبيا', 'code' => '+218', 'flag' => 'https://flagcdn.com/w320/ly.png'],
            // ['name_en' => 'Sudan', 'name_ar' => 'السودان', 'code' => '+249', 'flag' => 'https://flagcdn.com/w320/sd.png'],
            //  ['name_en' => 'Yemen', 'name_ar' => 'اليمن', 'code' => '+967', 'flag' => 'https://flagcdn.com/w320/ye.png'],
            // ['name_en' => 'Palestine', 'name_ar' => 'فلسطين', 'code' => '+970', 'flag' => 'https://flagcdn.com/w320/ps.png'],
        ];
    }
}

/**
 * Phone number length per country.
 */
if (! function_exists('phoneNumberLengths')) {
    function phoneNumberLengths()
    {
        return [
            '+966' => 9, '+968' => 8, '+971' => 9, '+965'  => 8,
            '+974' => 8, '+973' => 8, '+962' => 9, '+961'  => 8,
            '+963' => 9, '+964' => 10, '+20' => 10, '+212' => 9,
            '+213' => 9, '+216' => 8, '+218' => 9, '+249'  => 9,
            '+967' => 9, '+970' => 9,
        ];
    }
}

/**
 * Phone number example format per country.
 */
if (! function_exists('phoneNumberFormats')) {
    function phoneNumberFormats()
    {
        return [
            '+966' => '5xxxxxxxx', '+968'  => '9xxxxxxx', '+971'   => '5xxxxxxxx',
            '+965' => '6xxxxxxx', '+974'   => '3xxxxxxx', '+973'   => '3xxxxxxx',
            '+962' => '7xxxxxxxx', '+961'  => '7xxxxxxx', '+963'   => '9xxxxxxxx',
            '+964' => '7xxxxxxxxxx', '+20' => '1xxxxxxxxx', '+212' => '6xxxxxxxx',
            '+213' => '5xxxxxxxx', '+216'  => '2xxxxxxx', '+218'   => '9xxxxxxx',
            '+249' => '9xxxxxxxx', '+967'  => '7xxxxxxxx', '+970'  => '5xxxxxxxx',
        ];
    }
}

/**
 * This Function Format url slug and add the id
 * @param string $route name
 * @param string $name for the product or anything you need
 * @param int $id
 * example: slugUrl('product','how to make website',50);
 * return product/how-to-make-website-50;
 */
function slugUrl(string $route, string $name, int $id, bool $accept_arabic = false)
{
    // تحويل الاسم إلى lowercase (بالنسبة للعربي مش هيفرق)
    $slug = strtolower($name);

    if ($accept_arabic) {
        // يسمح بالحروف الإنجليزية + العربية + الأرقام + المسافة
        $slug = preg_replace('/[^\p{Arabic}a-z0-9\s]/u', '', $slug);
    } else {
        // يسمح بالإنجليزي والأرقام فقط
        $slug = preg_replace('/[^a-z0-9\s]/', '', $slug);
    }

    // استبدال المسافات بـ "-"
    $slug = preg_replace('/\s+/', '-', $slug);

    // إزالة أي "-" في البداية أو النهاية
    $slug = trim($slug, '-');

    return appUrl($route . '/' . $slug . '-' . $id);
}

/**
 * appUrl() return url with lang
 */
function appUrl($path)
{
    return url($path);

   // return url(lang() . '/' . $path);
}

/**
 * log_field()
 * Convert a database field name into a readable Arabic label.
 * This function uses the LogFields helper map.
 * If the field does not exist in the map, it returns the same field.
 */
if (! function_exists('log_field')) {

    function log_field($field)
    {
        // Load the Arabic field name map
        $map = \App\Helpers\LogFields::names();

        // Return the Arabic name if available, otherwise return the original field
        return $map[$field] ?? $field;
    }

}

/**
 * urlSwitchLang()
 * Switch the first URL segment between "ar" and "en" and return the new URL.
 */
function urlSwitchLang()
{
    $segments = request()->segments();

    if (isset($segments[0])) {
        if ($segments[0] === 'en') {
            $segments[0] = 'ar';
        } elseif ($segments[0] === 'ar') {
            $segments[0] = 'en';
        }

    }

    return url(implode('/', $segments));
}

/**
 * msg()
 * Translate a message key from resources/lang/{locale}/messages.php
 * Usage: msg('client.auth.email_exists')
 */
if (! function_exists('msg')) {
    function msg(string $key, array $replace = [], ?string $locale = null): string
    {
        return __("messages.$key", $replace, $locale);
    }
}

/**
 * youtubeEmbed()
 *
 *
 */
if (! function_exists('youtubeEmbed')) {
    /**
     * تحويل رابط يوتيوب لـ embed iframe صالح
     * @param string $url رابط يوتيوب
     * @return string embed URL أو الرابط الأصلي
     */
    function youtubeEmbed($url)
    {
        if (empty($url) || strpos($url, 'youtube.com') === false) {
            return $url;
        }

        // استخراج VIDEO_ID من أي رابط يوتيوب
        if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
            return "https://www.youtube.com/embed/{$videoId}?autoplay=1&rel=0&modestbranding=1";
        }

        return $url;
    }
}
