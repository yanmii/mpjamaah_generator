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
     * Build app
     *
     * @return \Illuminate\Http\Response
     */
    public function build()
    {
        // $keyword = $request->input('keyword');

       $file_path = '/Users/mrkahvi/android-projects/MIP/jamaah/assets/cfg/app_settings.json';
        $app_settings_json = file_get_contents($file_path);
        $app_setting = json_decode($app_settings_json);
        $app_setting->url_prod = "https://albiladuniversal.id/";
        $text = json_encode($app_setting, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents($file_path, $text);




        $resources = simplexml_load_file('/Users/mrkahvi/android-projects/MIP/jamaah/android/app/src/main/res/values/strings.xml');
        $resources->string[1][0] = "Fio Holiday";
        $resources->asXML('/Users/mrkahvi/android-projects/MIP/jamaah/android/app/src/main/res/values/strings.xml');




        $messaging_service_file_path = '/Users/mrkahvi/android-projects/MIP/jamaah/android/app/src/main/java/com/muslimpergi/umitravelapp/MessagingService.java';
        $messagin_service_content =  file_get_contents($messaging_service_file_path);

        $splitted = explode("setSmallIcon(R.mipmap.", $messagin_service_content);
        $splitted2 = explode(");", $splitted[1]);

        $ic_file = $splitted2[0];
        $new_ic_file = "logo_albilad";
        $messagin_service_content = str_replace("setSmallIcon(R.mipmap." .  $ic_file . ");", "setSmallIcon(R.mipmap." .  $new_ic_file . ");", $messagin_service_content);
        file_put_contents($messaging_service_file_path, $messagin_service_content);




        $my_service_file_path = '/Users/mrkahvi/android-projects/MIP/jamaah/android/app/src/main/java/com/muslimpergi/umitravelapp/MyService.java';
        $my_service_content =  file_get_contents($my_service_file_path);

        $splitted = explode("setSmallIcon(R.mipmap.", $my_service_content);
        $splitted2 = explode(");", $splitted[1]);

        $ic_file = $splitted2[0];
        $new_ic_file = "logo_albilad";
        $my_service_content = str_replace("setSmallIcon(R.mipmap." .  $ic_file . ");", "setSmallIcon(R.mipmap." .  $new_ic_file . ");", $my_service_content);
        file_put_contents($my_service_file_path, $my_service_content);


        $manifest_file_path = '/Users/mrkahvi/android-projects/MIP/jamaah/android/app/src/main/AndroidManifest.xml';
        $manifest = simplexml_load_file($manifest_file_path);
        echo '<pre>';
        print_r($manifest->application->{'meta-data'}[0]->attributes("android",TRUE)->value);
        $manifest->application->{'meta-data'}[0]->attributes("android",TRUE)->value = "8003b97c5ea645653fcb2451582464762a25d0f9cccc23fe12e7fe482ce8d0d0";
        // update
        $manifest->asXML($manifest_file_path);
        
        $dom = dom_import_simplexml($manifest)->ownerDocument;
        $dom->formatOutput = true;
        echo $dom->saveXML();



        $build_file_path = '/Users/mrkahvi/android-projects/MIP/jamaah/android/app/build.gradle';
        $build_content =  file_get_contents($build_file_path);

        $splitted = explode("applicationId \"", $build_content);
        $splitted2 = explode("\"", $splitted[1]);

        $text = $splitted2[0];
        $new_text = "com.muslimpergi.albilad";

        $build_content = str_replace("applicationId \"" .  $text . "\"", "applicationId \"" .  $new_text . "\"", $build_content);
        file_put_contents($build_file_path, $build_content);

        return "succeed";
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
  
        $site->update($request->all());
  
        return redirect()->route('sites.index')
                        ->with('success','site updated successfully');
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
