<tr>
    <td>
        {{ $prefix ?? '' }} {{ $category->name ?? '' }}
    </td>
    <td>
        @if ($category->parentCategory)
            {{ $category->parentCategory->name ?? '' }}
        @else
            <div class="text-danger" role="alert">
                {{ __('titles.root-category') }}
            </div>
        @endif
    </td>
    <td>
        <a href="{{ route('categories.edit', $category->id) }}"
            class="btn btn-sm" ui-toggle-class="">
            <i class='fa-solid fa-pen-to-square text-success'></i>
        </a>
        <form action="{{ route('categories.destroy', $category->id) }}"
            method="POST">
            @csrf
            @method('DELETE')
            <button id="#del" type="submit" class="btn btn-sm"
                onclick="ConfirmDelete('{{ __('messages.confirmDelete', ['name' => __('titles.category')]) }}')">
                <i class='fa-solid fa-trash text-danger'></i>
            </button>
        </form>
    </td>
</tr>
