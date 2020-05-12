@extends('sites.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>MP App Generator by MR Kahfi</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('sites.create') }}"> Create New site</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>App Name</th>
            <th>App Slug</th>
            <th>Android App ID</th>
            <th>iOS Bundle ID</th>
            <th>Logo</th>
            <th>Icon File</th>
            <th>Prod Base URL</th>
            <th>Whatsapp Number</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($sites as $site)
        <tr>
            <td>{{ ++$i }}</td>
            <td><a href="{{ route('sites.show',$site->id) }}">{{ $site->app_name }}</a></td>
            <td>{{ $site->slug }}</td>
            <td>{{ $site->app_id }}</td>
            <td>{{ $site->bundle_id }}</td>
            <td>{{ $site->logo }}</td>
            <td>{{ $site->ic_file }}</td>
            <td>{{ $site->url_prod }}</td>
            <td>{{ $site->url_wa }}</td>
            <td>
                <form action="{{ route('sites.destroy',$site->id) }}" method="POST">
                    <a class="btn btn-primary" href="{{ route('sites.edit',$site->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $sites->links() !!}
      
@endsection