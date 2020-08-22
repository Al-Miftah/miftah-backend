@extends('layouts.docs.main')

@section('content')
<div class="main-content">
    <div class="container-fluid">
        <h1>﷽</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <p>
                            Welcome to the API docs for Miftah. <br><br>
                            The base server url is <code>https://miftah.ultrasamad.com/api</code>.
                        </p>
                        <p>
                            Vist <a href="{{ route('donation.docs.pages') }}">here</a> for docs to donations APIs.
                        </p>
                        <p>
                            If you spot any typo or unexpected error or malformed response please contact <a href="mailto:naatogma@gmail.com">Samad</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection