<?php
namespace App\Http\Controllers\Dashboard\Settings;

use App\Helpers\File;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GeneralController extends Controller
{
    use SettingComponents;

    private const UPLOAD_PATH = 'settings';

    protected ?Settings $settings = null;

    public function __construct()
    {
        $this->settings = Settings::firstOrCreate([]);
    }

    /* =========================
       Views
    ========================= */

    public function index()
    {

        return view('dashboard.settings.general', [
            'tabs'     => self::$tabs,
            'links'    => self::$socialMedia,
            'row'      => $this->settings,
            'logoRule' => $this->fileRule(),
        ]);
    }

    /* =========================
       Main Store Router
    ========================= */

    public function store(Request $request)
    {

        Cache::forget('settings');

        return match ($request->action) {
            'general' => $this->storeGeneral($request),
            'contact' => $this->storeContact($request),
            'social'  => $this->storeSocial($request),
            default   => Response::error('Invalid action'),
        };
    }

    /* =========================
       Sections
    ========================= */

    protected function storeGeneral(Request $request)
    {
        $data = $request->validate([
            'logo'                     => $this->fileRule() . '|mimes:' . $this->pattern['image'],
            'footer_logo'              => $this->fileRule() . '|mimes:' . $this->pattern['image'],
            //  'website_name'             => 'required|max:100',
            //  'website_desc'             => 'nullable|max:3000',
            'google_map_address_embed' => 'nullable|max:5000',
            //  'address'                  => 'nullable|max:255',
        ]);

        $data['logo'] = File::upload('logo', [
            'path'   => self::UPLOAD_PATH,
            'delete' => $this->settings?->logo,
        ]);

        $data['footer_logo'] = File::upload('footer_logo', [
            'path'   => self::UPLOAD_PATH,
            'delete' => $this->settings?->website_icon,
        ]);

        $this->saveSettings($data);

        return Response::success('تم تحديث الإعدادات العامة بنجاح');
    }

    protected function storeSocial(Request $request)
    {
        $rules = array_fill_keys(
            array_keys(self::$socialMedia),
            'nullable|url|max:255'
        );

        $this->saveSettings($request->validate($rules));

        return Response::success('تم تحديث روابط السوشيال ميديا بنجاح', ['style' => 'toastr']);
    }

    protected function storeContact(Request $request)
    {
        $data = $request->validate([
            'email.*' => 'nullable|email|max:120',
            'phone.*' => 'nullable|numeric|digits_between:0,60',
        ]);

        $data['email'] = implode('|', $data['email'] ?? []);
        $data['phone'] = implode('|', $data['phone'] ?? []);

        $this->saveSettings($data);

        return Response::success('تم تحديث بيانات التواصل بنجاح', ['style' => 'toastr']);
    }

    /* =========================
       Helpers
    ========================= */

    protected function saveSettings(array $data): void
    {
        Settings::updateOrCreate(
            ['id' => $this->settings?->id],
            $data
        );

        $this->settings = Settings::first();
    }

    protected function fileRule(): string
    {
        return $this->settings->wasRecentlyCreated ? 'required' : 'nullable';
    }

}
