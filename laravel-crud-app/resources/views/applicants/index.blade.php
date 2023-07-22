@extends('applicants.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2>List of Applicants</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('applicants.create') }}"> Create New Applicant</a>
            </div>
        </div>
    </div>

    <!-- Add this form at the top of the index.blade.php -->
    <form action="{{ route('applicants.search') }}" method="GET" role="search">
        <div class="input-group">
            <input type="text" class="form-control" name="q" placeholder="Search applicants">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </form>

    @if (isset($applicants))
        <h2>Search Results</h2>
        @if ($applicants->isEmpty())
            <p>No applicants found.</p>
        @else
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Mobile Number</th>
                    <th>Previous Institution</th>
                    <th>Date of Birth</th>
                    <th width="280px">Action</th>
                </tr>
                @foreach ($applicants as $applicant)
                    <tr>
                        <td>{{ $applicant->id }}</td>
                        <td>{{ $applicant->name }}</td>
                        <td>{{ $applicant->mobile_number }}</td>
                        <td>{{ $applicant->previous_institution }}</td>
                        <td>{{ $applicant->date_of_birth }}</td>
                        <td>
                            <form action="{{ route('applicants.destroy', $applicant->id) }}" method="POST">
                                <a class="btn btn-info" href="{{ route('applicants.show', $applicant->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('applicants.edit', $applicant->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    @endif

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{ $applicants->links() }}
@endsection
