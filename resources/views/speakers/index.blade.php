
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>List of speakers</h2>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($speakers as $speaker)
                            <tr>
                                <td>{{ $speaker->name }}</td>
                                <td>{{ $speaker->address }}</td>
                                <td>{{ $speaker->phone }}</td>
                                <td>
                                    <a href="">
                                        <span class="fa fa-pencil-alt"></span>
                                    </a>&nbsp;
                                    <a href="">
                                        <span class="fa fa-eye"></span>
                                    </a>&nbsp;
                                    <a href="">
                                        <span class="fa fa-trash"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <a href="{{ route('speakers.create') }}">Add new speaker</a>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
