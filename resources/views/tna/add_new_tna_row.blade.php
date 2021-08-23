<tr>
    <td class="text-center">
        <input type="text" id="" class="form-control" name="tna_term[]" required="required" autocomplete="off">
    </td>
    <td class="text-center">
        <input type="number" class="form-control" name="days[]" required="required" autocomplete="off">
    </td>
    <td class="text-center">
        <select class="form-control" name="responsible_department[]" required="required">
            <option value="">Select Department</option>

            @foreach($user_types AS $user_type)
                <option value="{{ $user_type->id }}">
                    {{ $user_type->user_type }}
                </option>
            @endforeach

        </select>
    </td>
    <td class="text-center">
        <input type="checkbox" name="tna_term_status[]" checked="checked" value="1">
    </td>
    <td class="text-center">
        <span class="btn btn-sm btn-danger" id="DeleteTnaTermButton"><i class="fas fa-trash"></i></span>
    </td>
</tr>