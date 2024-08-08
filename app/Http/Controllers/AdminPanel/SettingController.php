<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\AdminPanel\CreateSettingRequest;
use App\Http\Requests\AdminPanel\UpdateSettingRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Flash;

class SettingController extends AppBaseController
{
    /** @var SettingRepository $settingRepository*/
    private $settingRepository;

    public function __construct(SettingRepository $settingRepo)
    {
        $this->settingRepository = $settingRepo;

        $this->middleware('permission:Edit Setting', ['only' => ['index', 'store']]);
        // $this->middleware('permission:Add Slider', ['only' => ['create', 'store']]);
        // $this->middleware('permission:Edit Slider', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:Delete Slider', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        $settings = Setting::first();
        return view('AdminPanel.settings.index', get_defined_vars() );
    }


    // public function create()
    // {
    //     return view('settings.create');
    // }


    public function store(CreateSettingRequest $request)
    {
        $input = $request->all();
        $settings = Setting::first();

        if( $settings ) {
            $setting = $this->settingRepository->update($input,$settings->id);
        } else {
            $setting = $this->settingRepository->create($input);
        }
        return redirect()->route('settings.index')->with('success' , __('lang.updated') );
    }

    /**
     * Display the specified Setting.
     */
    // public function show($id)
    // {
    //     $setting = $this->settingRepository->find($id);

    //     if (empty($setting)) {
    //         Flash::error('Setting not found');

    //         return redirect(route('settings.index'));
    //     }

    //     return view('settings.show')->with('setting', $setting);
    // }

    /**
     * Show the form for editing the specified Setting.
     */
    // public function edit($id)
    // {
    //     $setting = $this->settingRepository->find($id);

    //     if (empty($setting)) {
    //         Flash::error('Setting not found');

    //         return redirect(route('settings.index'));
    //     }

    //     return view('settings.edit')->with('setting', $setting);
    // }

    /**
     * Update the specified Setting in storage.
     */
    // public function update($id, UpdateSettingRequest $request)
    // {
    //     $setting = $this->settingRepository->find($id);

    //     if (empty($setting)) {
    //         Flash::error('Setting not found');

    //         return redirect(route('settings.index'));
    //     }

    //     $setting = $this->settingRepository->update($request->all(), $id);

    //     Flash::success('Setting updated successfully.');

    //     return redirect(route('settings.index'));
    // }

    /**
     * Remove the specified Setting from storage.
     *
     * @throws \Exception
     */
    // public function destroy($id)
    // {
    //     $setting = $this->settingRepository->find($id);

    //     if (empty($setting)) {
    //         Flash::error('Setting not found');

    //         return redirect(route('settings.index'));
    //     }

    //     $this->settingRepository->delete($id);

    //     Flash::success('Setting deleted successfully.');

    //     return redirect(route('settings.index'));
    // }
}
