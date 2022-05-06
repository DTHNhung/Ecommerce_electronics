@extends('admin.admin_layout')
@section('admin_content')
<h4 class="page-title">{{ __('titles.category') }}</h4>
<div class="panel panel-default">
    <a  href="{{ route('categories.create') }}"
        class="btn-add">
        <i class="fa-solid fa-circle-plus"></i>
        <span>{{ __('titles.add-category') }}</span>
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
        <table class="table table-hover mt-10" id="categories_table">
            <thead>
                <tr>
                    <th>{{ __('titles.name-var', ['name' => __('titles.category')]) }}
                    </th>
                    <th>{{ __('titles.parent-category') }}</th>
                    <th class="width-css"></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $index = 0;
                @endphp
                @foreach ($allCategory as $key => $category)
                    @include(
                        'admin.category.index_row',
                        compact('category', 'index')
                    )

                    @foreach ($category->childCategories as $childCategory)
                        @include(
                            'admin.category.index_row',
                            [
                                'category' => $childCategory,
                                'prefix' => '-----',
                            ]
                        )

                        @foreach ($childCategory->childCategories as $childCategory)
                            @include(
                                'admin.category.index_row',
                                [
                                    'category' => $childCategory,
                                    'prefix' => '-----------',
                                ]
                            )
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('dataTable')
    <script>
        $(function() {
            $("#categories_table").DataTable();
        });
    </script>
@endsection
