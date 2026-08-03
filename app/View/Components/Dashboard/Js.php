<?php

namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class Js extends Component
{

    const DASHBOARD_ASSETS_PATH = 'dashboard/';
    const JS_PATH               = self::DASHBOARD_ASSETS_PATH . 'js/';

    public $folders = ['layouts', 'pages', 'components', 'plugins'];


    public $files  = [];

    public $errors = [];






    public function multiFiles($links)
    {

        $fromFolder = '';
        $count = 0;
        foreach ($links as $row) {
            $count++;
            // Check If Have External File
            if (isset($row['external'])) {
                $this->files[] = [
                    'external' => $row['external'],
                    'type' => isset($row['type']) ? $row['type'] : 'text/javascript'
                ];
            } else {
                // Else This File From Project
                if (isset($row['link'])) {

                    // Check IF Folder From Exists
                    if (isset($row['from'])) {

                        $folderPrefix = $row['from'];

                        if (in_array($folderPrefix, $this->folders)) {

                            // Check IF ( from Folder = plugins ) Not Set js Perfix IN Path
                            $fromFolder = $folderPrefix == 'plugins' ?  self::DASHBOARD_ASSETS_PATH . $folderPrefix  : self::JS_PATH  . $folderPrefix;

                            $fromFolder .= '/';
                            
                        } else {
                            $this->errors[] = 'Not Exist [ ' . $folderPrefix . ' ] JavaScript folder in list, can choose from this [ ' . implode(' , ', $this->folders) . ' ]';
                        }
                    } else {

                        $fromFolder =  self::JS_PATH . 'pages/';
                    }



                    $this->files[] = [
                        'link' => $fromFolder  . $row['link'],
                        //  'from' => ,
                        'type' => isset($row['type']) ? $row['type'] : 'text/javascript'
                    ];
                } else {
                    $this->errors[] = "Your JavaScript File Index Number [ $count ] Don't Exist";
                }
            }
        }
    }

    public function singleFile($link, $from, $type, $external)
    {
        $this->files[] = [
            'link' => $external != null ? $external : self::JS_PATH . $from . '/' . $link,
            //  'from' => ,
            'type' => isset($type) ? $type : 'text/javascript'
        ];
    }

    public function errors()
    {
        foreach ($this->errors as $error) {
            abort(301, $error);
        }
    }


    public function __construct(array $links = [], string $link = '', string $from = 'pages', string $type = 'text/javascript', string $external = '')
    {

        // Check IF Links Multi
        if (!empty($links)) {
            $this->multiFiles($links);
        } else {
            // Else Single File
            $this->singleFile($link, $from, $type, $external);
        }

        // Check IF Have Errors To Display
        if (!empty($this->errors)) {
            $this->errors();
        }
    }

    public function render()
    {
        return view('components.dashboard.js');
    }
}
