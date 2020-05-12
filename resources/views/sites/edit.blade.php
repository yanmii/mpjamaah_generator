@extends('sites.layout')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit site</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('sites.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('sites.update',$site->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>App Name:</strong>
                    <input type="text" name="app_name" value="{{ $site->app_name }}" class="form-control" placeholder="App Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Slug:</strong>
                    <input type="text" name="slug" value="{{ $site->slug }}" class="form-control" placeholder="App Slug">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Android App ID:</strong>
                    <input type="text" name="app_id" value="{{ $site->app_id }}" class="form-control" placeholder="applicationId">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>iOS Bundle ID:</strong>
                    <input type="text" name="bundle_id" value="{{ $site->bundle_id }}" class="form-control" placeholder="Bundle Identifier">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Logo:</strong>
                    <input type="text" name="logo" value="{{ $site->logo }}" class="form-control" placeholder="logo with extension">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Icon File:</strong>
                    <input type="text" name="ic_file" value="{{ $site->ic_file }}" class="form-control" placeholder="icon file without extension">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Prod Base URL:</strong>
                    <input type="text" name="url_prod" value="{{ $site->url_prod }}" class="form-control" placeholder="with https://">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Whatsapp Number</strong>
                    <input type="text" name="url_wa" value="{{ $site->url_wa }}" class="form-control" placeholder="preceeded by 62">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Transistorsoft License Key</strong>
                    <input type="text" name="ts_license_key" value="{{ $site->ts_license_key }}" class="form-control" placeholder="Transistorsoft License Key">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12"></div>
            <table>
                <tr>
                    <td>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit"  name="action" value="save" class="btn btn-primary">Submit</button>
            </div>
            </td>
            <td>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit"  name="action" value="build" class="btn btn-info">Build</button>
            </div>
        </td>
    </tr>
            </table>
        </div>
   
    </form>

@endsection