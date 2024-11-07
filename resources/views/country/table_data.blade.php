@if ($countries->count() > 0)
    @foreach ($countries as $key => $country)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td class="productWrap d-flex align-items-center">
                {{ $country->country_name }}
            </td>
            <td>
                {{ $country->state?->count() }}
            </td>
            <td>
                <div class="dropdown custom__dropdown">
                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="las la-ellipsis-h"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a href="javascript:;" class="dropdown-item"
                                onclick="editData('{{ route('country.edit', $country->id) }}')">
                                Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="dropdown-item"
                                onclick="deleteData('{{ $country->id }}', '{{ route('country.delete', $country->id) }}')">
                                Delete
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="3" class="text-danger text-center">
            No data found
        </td>
    </tr>
@endif
