@extends('admin.admin_layout')
@section('admin_content')

<h4 class="page-title">{{ __('titles.brand') }}</h4>
<div class="panel panel-default">
    <a  href="{{ route('brands.create') }}"
        class="btn-add">
        <i class="fa-solid fa-circle-plus"></i>
        <span>{{ __('titles.add-brand') }}</span>
    </a>
    <div class="table-responsive">
        @php
            $mess = Session::get('mess');
        @endphp
        @if ($mess)
            <span class="text-alert">{{ $mess }}
            </span>
            <br><br>
            @php
                Session::put('mess', null);
            @endphp
        @endif
        <table class="table table-hover mt-10" id="brands_table">
            <thead>
                <tr>
                    <th class="width-css">
                    </th>
                    <th>{{ __('titles.brand-name') }}</th>
                    <th class="width-css"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($all_brand as $key => $brand_pro)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <p class="stt">
                                {{ $brand_pro->name }}</p>
                        </td>
                        <td>
                            <a href="{{ route('brands.edit', ['brand' => $brand_pro->id]) }}"
                                class="btn btn-sm"
                                ui-toggle-class="">
                                <i class='fa-solid fa-pen-to-square text-success'></i>
                            </a>
                            <form
                                action="{{ route('brands.destroy', ['brand' => $brand_pro->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm"
                                    onclick="return confirm('{{ __('messages.confirmDelete', ['name' => __('titles.brand')]) }}')">
                                    <i class='fa-solid fa-trash text-danger'></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('dataTable')
    <script>
        $(function() {
            $("#brands_table").DataTable();
        });
    </script>
@endsection
