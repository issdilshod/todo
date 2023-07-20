@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            {!! implode('', $errors->all('<li>:message</li>')) !!}
        </ul>
    </div>
@endif