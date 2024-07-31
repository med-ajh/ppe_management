@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cost Centers') }}</div>

                <div class="card-body">
                    <a href="{{ route('cost_centers.create') }}" class="btn btn-primary mb-3">{{ __('Create Cost Center') }}</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($costCenters as $costCenter)
                                <tr>
                                    <td>{{ $costCenter->name }}</td>
                                    <td>{{ $costCenter->department->name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('cost_centers.edit', $costCenter->id) }}" class="btn btn-warning">{{ __('Edit') }}</a>
                                        <form action="{{ route('cost_centers.destroy', $costCenter->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
