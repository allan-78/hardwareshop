<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function edit()
    {
        $settings = [
            'site_name' => config('app.name'),
            'site_email' => config('mail.from.address'),
            'currency' => config('app.currency', 'PHP'),
            'items_per_page' => config('app.pagination.per_page', 10),
        ];

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'currency' => 'required|string|size:3',
            'items_per_page' => 'required|integer|min:5|max:100',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Update settings in .env file
        $this->updateEnvironmentFile([
            'APP_NAME' => $validated['site_name'],
            'MAIL_FROM_ADDRESS' => $validated['site_email'],
            'APP_CURRENCY' => $validated['currency'],
            'PAGINATION_PER_PAGE' => $validated['items_per_page'],
        ]);

        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('public/site');
            // Store logo path in settings
            // You might want to implement a settings table in database
        }

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully');
    }

    private function updateEnvironmentFile($data)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $content = file_get_contents($path);
            foreach ($data as $key => $value) {
                $content = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}=" . $value,
                    $content
                );
            }
            file_put_contents($path, $content);
        }
    }
}