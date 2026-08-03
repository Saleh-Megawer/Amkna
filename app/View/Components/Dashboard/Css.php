<?php

namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class Css extends Component
{
    const DASHBOARD_ASSETS_PATH = 'dashboard/';
    const CSS_PATH              = self::DASHBOARD_ASSETS_PATH . 'css/';

    public $folders = [
        'components',
        'directions',
        'global',
        'layouts',
        'pages',
        'plugins', // This Outside css folder
        'views'
    ];



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
                $this->files[] = $row['external'];
            } else {
                // Else This File From Project
                if (isset($row['link'])) {

                    // Check IF Folder From Exists
                    if (isset($row['from'])) {

                        $folderPrefix = $row['from'];

                        if (in_array($folderPrefix, $this->folders)) {

                            // Check IF ( from Folder = plugins ) Not Set js Perfix IN Path
                            $fromFolder = $folderPrefix == 'plugins' ?  self::DASHBOARD_ASSETS_PATH . $folderPrefix  : self::CSS_PATH  . $folderPrefix;

                            $fromFolder .= '/';
                        } else {
                            $this->errors[] = 'Not Exist [ ' . $folderPrefix . ' ] css folder in list, can choose from this [ ' . implode(' , ', $this->folders) . ' ]';
                        }
                    } else {

                        $fromFolder =  self::CSS_PATH . 'pages/';
                    }

                    $this->files[] = $fromFolder  . $row['link'];
                } else {
                    $this->errors[] = "Your Css File Index Number [ $count ] Don't Exist";
                }
            }
        }
    }


    public function singleFile($link, $from, $external)
    {
        if (in_array($from, $this->folders)) {
            $this->files[] = $external != null ? $external : self::CSS_PATH . $from . '/' . $link;
        } else {
            $this->errors[] = 'Not Exist [ ' . $from . ' ] css folder in list, can choose from this [ ' . implode(' , ', $this->folders) . ' ]';
        }
    }


    public function errors()
    {
        foreach ($this->errors as $error) {
            abort(301, $error);
        }
    }

    public function __construct(array $links = [], string $link = '', string $from = 'pages', string $external = '')
    {

        // Check IF Links Multi
        if (!empty($links)) {
            $this->multiFiles($links);
        } else {
            // Else Single File
            $this->singleFile($link, $from, $external);
        }

        // Check IF Have Errors To Display
        if (!empty($this->errors)) {
            $this->errors();
        }
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.css');
    }
}
