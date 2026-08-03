<?php
namespace App\Http\Controllers\Dashboard\Pages\About;

use App\Http\Controllers\Controller;
use App\Models\About\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{

    public function index()
    {

        $about = About::with('translations')->firstOrCreate([]);

                                 // جلب كل اللغات المتاحة
        $locales = ['ar', 'en']; // أو من config

        $translations = [];
        foreach ($locales as $locale) {
            $translation = $about->translations()->where('locale', $locale)->first();

            if (! $translation) {
                $translation = $about->translations()->create([
                    'locale'      => $locale,
                    'our_journey' => [],
                ]);
            }

            $translations[$locale] = $translation;
        }

        return view('dashboard.pages.about.index', compact('about', 'translation', 'locales'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'about_id'              => 'required|exists:abouts,id',
            'locales'               => 'required|array',
            'our_journey'           => 'required|array',
            'our_journey.*'         => 'array',
            'our_journey.*.*.id'    => 'required|string',
            'our_journey.*.*.title' => 'required|string|max:500',
            'our_journey.*.*.desc'  => 'required|string',
            'our_journey.*.*.icon'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'برجاء مراجعة الأخطاء');
        }

        $about = About::findOrFail($request->about_id);

        // حفظ كل لغة
        foreach ($request->locales as $locale) {
            $journeyData = $request->our_journey[$locale] ?? [];

            $about->translations()->updateOrCreate(
                ['locale' => $locale],
                ['our_journey' => array_values($journeyData)]// إعادة ترتيب الـ indices
            );
        }

        return redirect()->back()->with('success', 'تم الحفظ بنجاح');
    }

}
