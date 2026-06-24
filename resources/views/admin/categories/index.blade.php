 @extends('layouts.admin')

<title> Admin | Categories</title>

@push('styles')
<style>
     a{
        height: 20px;
        width : 80px:
     }
    </style>
@endpush

@section('content')
 <div>
<a href="{{ route('admin.categories.create') }}">
    create
</a>
    </div>
@endsection

@push('scripts')

@endpush