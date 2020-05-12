<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = site::latest()->paginate(10);
  
        return view('sites.index',compact('sites'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'app_name' => 'required',
            'slug' => 'required',
            'app_id' => 'required',
            'bundle_id' => 'required',
            'logo' => 'required',
            'ic_file' => 'required',
            'url_prod' => 'required',
            'url_wa' => 'required',
            'ts_license_key' => 'required',
        ]);
  
        site::create($request->all());
   
        return redirect()->route('sites.index')
                        ->with('success','site created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
        return view('sites.show',compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        return view('sites.edit',compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        $request->validate([
            'app_name' => 'required',
            'slug' => 'required',
            'app_id' => 'required',
            'bundle_id' => 'required',
            'logo' => 'required',
            'ic_file' => 'required',
            'url_prod' => 'required',
            'url_wa' => 'required',
            'ts_license_key' => 'required',
        ]);
        switch ($request->input('action')) {
            case 'save':
                $site->update($request->all());
          
                return redirect()->route('sites.index')
                            ->with('success','site updated successfully');
                break;

            case 'build':
                $this->build($site);

                return redirect()->route('sites.index')
                        ->with('success','app built successfully');
                break;

            default: 
                return redirect()->route('sites.index')
                            ->with('success','site updated successfully');
        }

    }

    public function build(Site $site)
    {
        $file_path = '/Users/mrkahvi/android-projects/MIP/jamaah/assets/cfg/app_settings.json';
        $app_settings_json = file_get_contents($file_path);
        $app_setting = json_decode($app_settings_json);
        $app_setting->url_prod = $site->url_prod;
        $app_setting->app_name = $site->app_name;
        $app_setting->logo = "assets/img/logo/" . $site->logo;
        $app_setting->url_wa = $site->url_wa;
        $text = json_encode($app_setting, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents($file_path, $text);


        $resources = simplexml_load_file('/Users/mrkahvi/android-projects/MIP/jamaah/android/app/src/main/res/values/strings.xml');
        $resources->string[1][0] = $site->app_name;
        $resources->asXML('/Users/mrkahvi/android-projects/MIP/jamaah/android/app/src/main/res/values/strings.xml');


        $messaging_service_file_path = '/Users/mrkahvi/android-projects/MIP/jamaah/android/app/src/main/java/com/muslimpergi/umitravelapp/MessagingService.java';
        $messagin_service_content =  file_get_contents($messaging_service_file_path);
        $splitted = explode("setSmallIcon(R.mipmap.", $messagin_service_content);
        $splitted2 = explode(");", $splitted[1]);
        $ic_file = $splitted2[0];
        $new_ic_file = $site->ic_file;
        $messagin_service_content = str_replace("setSmallIcon(R.mipmap." .  $ic_file . ");", "setSmallIcon(R.mipmap." .  $new_ic_file . ");", $messagin_service_content);
        file_put_contents($messaging_service_file_path, $messagin_service_content);


        $my_service_file_path = '/Users/mrkahvi/android-projects/MIP/jamaah/android/app/src/main/java/com/muslimpergi/umitravelapp/MyService.java';
        $my_service_content =  file_get_contents($my_service_file_path);
        $splitted = explode("setSmallIcon(R.mipmap.", $my_service_content);
        $splitted2 = explode(");", $splitted[1]);
        $ic_file = $splitted2[0];
        $new_ic_file = $site->ic_file;
        $my_service_content = str_replace("setSmallIcon(R.mipmap." .  $ic_file . ");", "setSmallIcon(R.mipmap." .  $new_ic_file . ");", $my_service_content);
        file_put_contents($my_service_file_path, $my_service_content);


        $manifest_file_path = '/Users/mrkahvi/android-projects/MIP/jamaah/android/app/src/main/AndroidManifest.xml';
        $manifest = simplexml_load_file($manifest_file_path);
        $manifest->application->{'meta-data'}[0]->attributes("android",TRUE)->value = $site->ts_license_key;
        $manifest->asXML($manifest_file_path);
        $dom = dom_import_simplexml($manifest)->ownerDocument;
        $dom->formatOutput = true;


        $build_file_path = '/Users/mrkahvi/android-projects/MIP/jamaah/android/app/build.gradle';
        $build_content =  file_get_contents($build_file_path);
        $splitted = explode("applicationId \"", $build_content);
        $splitted2 = explode("\"", $splitted[1]);
        $text = $splitted2[0];
        $new_text = $site->app_id;
        $build_content = str_replace("applicationId \"" .  $text . "\"", "applicationId \"" .  $new_text . "\"", $build_content);
        file_put_contents($build_file_path, $build_content);
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        $site->delete();
  
        return redirect()->route('sites.index')
                        ->with('success','site deleted successfully');
    }

}
