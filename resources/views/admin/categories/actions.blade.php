<a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900 mr-3">
    Edit
</a>
<button type="button" 
    class="text-red-600 hover:text-red-900 delete-category" 
    data-id="{{ $category->id }}">
    Delete
</button>

<form id="delete-form-{{ $category->id }}" 
    action="{{ route('admin.categories.destroy', $category) }}" 
    method="POST" 
    style="display: none;">
    @csrf
    @method('DELETE')
</form>