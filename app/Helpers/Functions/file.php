<?php



/**
 * Files Ext
 */
function filesExtensions($array = true)
{
    $items = ["DOCX", "HTML", "HTM", "ODT", "P DF", "XLS", "XLSX", "ODS", "PPT", "PPTX", "TXT", "AIFF", "AU", "AVI", "BAT", "CLASS", "JAVA", "CSV", "CVS", "DBF", "DIF", "EPS", "EXE", "FM3", "GIF", "HQX", "MAP", "MDB", "MID", "MIDI", "MOV", "QT", "P65", "T65", "PSD", "PSP", "QXD", "RA", "SIT", "TAR", "TIF", "WAV", "WK3", "WKS", "WPD", "WP5", "RAR", "ZIP", "AI", "MP4", "MP3", "AAC", "ADT", "ADTS", "ACCDB", "ACCDE", "ACCDR", "AIF", "AIFC", "ASPX", "BIN", "BMP", "CAB", "CDA", "DLL", "DOC", "DOCM", "DOT", "DOTX", "EML", "FLV", "INI", "ISO", "JAR", "M4A", "MPEG", "MPG", "MSI", "MUI", "POT", "POTM", "POTX", "PPAM", "PPS", "PPSM", "PPSX", "PPTM", "PST", "PUB", "RTF", "SLDM", "SLDX", "SWF", "SYS", "TMP", "VOB", "VSD", "VSDM", "VSDX", "VSS", "VSSM", "VST", "VSTM", "VSTX", "WBK", "WMA", "WMD", "WMV", "WMZ", "WMS", "XLA", "XLAM", "XLL", "XLSM", "XLT", "XLTM", "XLTX", "XPS", "XD", "FIG"];
    if ($array == true) {
        // UPPER CASE
        return $items;
    } else {
        return implode(',', $items);
    }
}




/**
 * Function Get Storage Path From Public
 */
function storageAsset(string $path)
{
    return asset('storage/' . $path);
}
function largeAsset(string $path)
{
    return storageAsset('large/'. $path);
}
function mediumAsset(string $path)
{
    return storageAsset('medium/'. $path);
}
function smallAsset(string $path)
{
    return storageAsset('small/'. $path);
}


/**
 * Function Get Storage Path From Public
 */
function storageLinkPath(string $path)
{
    return public_path('storage/' . $path);
}
function largePath(string $path)
{
    return storageLinkPath('large/'. $path);
}
function mediumPath(string $path)
{
    return storageLinkPath('medium/'. $path);
}
function smallPath(string $path)
{
    return storageLinkPath('small/'. $path);
}
