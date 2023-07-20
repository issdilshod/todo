@extends('layouts.master')

@section('title', 'Home')

@section('content')

    <div class="container">

        <div class="d-flex mb-4 mt-4">
            <h4>Lists</h4>
            <div class="ml-auto">
                <button class="btn btn-primary" onclick="clickAdd()">Add</button>
            </div>
        </div>

        <div class="row custom-list">

            @foreach ($cards as $card)
                <div class="col-12 col-sm-3 mb-2 custom-list-item" data-id="{{ $card['id'] }}">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{ $card['img'] }}" alt="{{ $card['name'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $card['name'] }}</h5>
                            <a class="btn btn-primary" onclick="getCard({{ $card['id'] }})">Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div>
    </div>

    @include('modals.listCard')
@stop

@section('scripts')
<script>
    let cardId = '';
    let csrf = '{{ csrf_token() }}';
    let modalId = '#exampleModal';
    let listClass = '.custom-list';

    function clickAdd()
    {
        cardId = '';
        $(modalId + ' img').hide();
        $(modalId).modal('show');
    }

    function getCard(id){
        $.ajax({
            url: "{{ route('api.card.get') }}/" + id,
            type: 'get',
            success: function(data){
                if (data){
                    $(modalId + ' input[name="name"]').val(data.name);
                    $(modalId + ' img').show();
                    $(modalId + ' img').attr('src', data.img);
                    $(modalId).modal('show');
                }

                cardId = id;
            }
        });
    }

    function saveCard(){
        if (cardId!=''){
            updateCard();
        }else{
            addCard();
        }

        setModal();
    }

    function addCard(){
        const formData = new FormData();
        formData.append('_token', csrf);
        if ($(modalId + ' input[name="img"]')[0].files[0]){
            formData.append('img', $(modalId + ' input[name="img"]')[0].files[0]);
        }
        formData.append('name', $(modalId + ' input[name="name"]').val());

        $.ajax({
            url: "{{ route('api.card.create') }}",
            type: 'post',
            data: formData,
            success: function(data){

                if (data){
                    $(listClass).prepend(
                        '<div class="col-12 col-sm-3 mb-2 custom-list-item" data-id="'+data.id+'">' +
                            '<div class="card" style="width: 18rem;">'+
                                '<img class="card-img-top" src="'+data.img+'" alt="'+data.name+'">'+
                                '<div class="card-body">'+
                                    '<h5 class="card-title">'+data.name+'</h5>'+
                                    '<a class="btn btn-primary" onclick="getCard('+data.id+')">Edit</a>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );
                }
                
            },
            complete: function(){
                $(modalId).modal('hide');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    function updateCard(){
        const formData = new FormData();
        formData.append('_token', csrf);
        if ($(modalId + ' input[name="img"]')[0].files[0]){
            formData.append('img', $(modalId + ' input[name="img"]')[0].files[0]);
        }
        formData.append('name', $(modalId + ' input[name="name"]').val());
        formData.append('_method', 'put');

        $.ajax({
            url: "{{ route('api.card.update') }}/" + cardId,
            type: 'post',
            data: formData,
            success: function(data){
                
                if (data){
                    $(listClass + ' .custom-list-item[data-id="'+data.id+'"]').html(
                        '<div class="card" style="width: 18rem;">'+
                            '<img class="card-img-top" src="'+data.img+'" alt="'+data.name+'">'+
                            '<div class="card-body">'+
                                '<h5 class="card-title">'+data.name+'</h5>'+
                                '<a class="btn btn-primary" onclick="getCard('+data.id+')">Edit</a>'+
                            '</div>'+
                        '</div>'
                    );
                }
                
            },
            complete: function(){
                $(modalId).modal('hide');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    function setModal(data = {})
    {
        $(modalId + ' input[name="name"]').val((data['name'])?data['name']:'');
        $(modalId + ' input[name="img"]').val('');
    }
</script>
@stop