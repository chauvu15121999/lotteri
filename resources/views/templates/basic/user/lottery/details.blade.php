@extends($activeTemplate . 'layouts.' . $layout)
@section('content')
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="lottery-details-header">
                        <div class="thumb"><img
                                src="{{ getImage(getFilePath('lottery') . '/' . @$phase->lottery->image, getFileSize('lottery')) }}" alt="image"></div>
                        <div class="content text-center">
                            <h3 class="game-name mb-4">{{ __($phase->lottery->name) }}</h3>
                            <div class="clock" data-clock="{{ showDateTime($phase->draw_date, 'Y/m/d H:i:s') }}" data-title="@lang('The lottery is expired')"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-12">

                    @if ($phase->available)
                        @auth
                            <form class="submit-form" method="post" action="{{ route('user.buy.ticket') }}">
                                @csrf
                                <input name="lottery_id" type="hidden" value="{{ $phase->lottery->id }}">
                                <input name="phase_id" type="hidden" value="{{ $phase->id }}">

                                <div class="lottery-details-body">
                                    <div class="top-part">
                                        <div class="left">
                                            <h4>@lang('Available Ticket'): {{ __($phase->available) }}</h4>
                                            <h4 class="mt-2">@lang('Price'):
                                                {{ __($general->cur_sym) }}{{ __(showAmount($phase->lottery->price)) }}</h4>
                                        </div>
                                        <div class="middle">
                                            <div class="balance">@lang('Balance'):
                                                {{ __($general->cur_sym) }}{{ showAmount(auth()->user()->balance) }}</div>
                                        </div>
                                        <div class="right">
                                            <button class="btn btn-md btn-outline--base addMore" type="button"><i
                                                    class="la la-plus"></i> @lang('Add New')</button>
                                        </div>
                                    </div>
                                    <div class="body-part">
                                        <div class="row gy-4" id="tickets">

                                            <div class="col-xl-4 col-md-6">
                                                <div class="ticket-card">
                                                    <div class="ticket-card__header">
                                                        <h4>@lang('Your Ticket Number')</h4>
                                                    </div>
                                                    <div class="ticket-card__body elements" id="unique-numbers">
                                                        <input class="numVal" name="number[]" type="hidden">
                                                        <div class="number-group numbers uniqueNumbers mb-4">
                                                            @for ($i = 0 ; $i < $phase->digits; $i++)
                                                                <span>0</span>
                                                            @endfor
                                                        </div>
                                                        <div class="form-group uniqueNumbers row ps-3 pe-3" style="display: none;">
                                                            <input class="form-control numberItem col-12"  type="number" placeholder="Enter Number" maxlength="{{$phase->digits}}"  />
                                                            <span style="display: none; color: red;" class="errMsg col-12 mt-3"></span>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" data-type="unique-numbers" data-id="generates1" type="radio" name="isGenerates" value="true" checked>
                                                                <label class="form-check-label" for="generates1">
                                                                    Generate Number
                                                                </label>
                                                            </div>
                                                        <div class="form-check form-check-inline">
                                                            <input value="false" data-id="generates2" data-type="unique-numbers" class="form-check-input" type="radio" name="isGenerates">
                                                                <label class="form-check-label" for="generates2">
                                                                    Enter Number
                                                                </label>
                                                        </div>
                                                        <button class="btn btn-md btn--base w-100 generate" data-type="unique-numbers" type="button">@lang('Generate')</button>
                                                    </div>
                                                </div><!-- ticket-card end -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer-part gap-3">
                                        <div class="left">
                                            <p>@lang('1 Draw with') <span class="qnt">1</span> @lang('ticket') : <span
                                                    class="qnt">1</span> x {{ getAmount($phase->lottery->price) }}
                                                {{ __($general->cur_text) }}</p>
                                            <p class="mt-2">@lang('Total Amount') : <span
                                                    class="tam">{{ getAmount($phase->lottery->price) }}</span>
                                                <span>{{ $general->cur_text }}</span>
                                            </p>
                                        </div>
                                        <div class="right">
                                            @auth
                                                <button class="btn btn-md btn-outline--base buyBtn" type="button"><i
                                                        class="la la-shopping-bag"></i> @lang('Buy Now')</button>
                                            @endauth
                                        </div>
                                    </div>
                                </div><!-- lottery-details-body end -->
                            </form>
                        @else
                            <div class="lottery-details-body">
                                <div class="top-part">
                                    <div class="left">
                                        <h4>@lang('Available Ticket'): {{ __($phase->available) }}</h4>
                                        <h4 class="mt-2">@lang('Price'):
                                            {{ __($general->cur_sym) }}{{ __(showAmount($phase->lottery->price)) }}</h4>
                                    </div>
                                </div>
                                <div class="footer-part gap-3">
                                    <div class="middle">
                                        <h4>@lang('Please log in to purchase lottery tickets')</h4>
                                    </div>
                                    <div class="right">
                                        <a href="{{ route('user.login') }}"><button class="btn btn-md btn-outline--base" type="button"><i class="la la-user"></i> @lang('Login')</button></a>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    @else
                        <div class="lottery-details-body">
                            <div class="top-part">
                                <div class="w-100">
                                    <h4> @lang('All Tickets are sold') </h4>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="lottery-details-instruction mt-5">
                        <ul class="nav nav-tabs cumtom--nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active px-4" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">@lang('Instruction')</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link px-4" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">@lang('Win Bonuses')</button>
                            </li>
                            @auth
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link px-4" id="profile-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">@lang('Purchased Tickets')</button>
                                </li>
                            @endauth
                        </ul>
                        <div class="tab-content mt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="d-block">
                                    <h3 class="mb-3">@lang('Introduction')</h3>
                                    @php echo $phase->lottery->instruction @endphp
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="table-responsive--md">
                                    <table class="level-table custom--table table">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase">@lang('Winners')</th>
                                                <th class="text-uppercase">@lang('Win Bonus')</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($phase->lottery->bonuses as $bonus)
                                                <tr>
                                                    <td class="text-white">@lang('Winner')- {{ $bonus->level }}</td>
                                                    <td class="text-white">{{ $bonus->amount }}
                                                        {{ __($general->cur_text) }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @auth
                                <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                                    <div class="table-responsive--md">
                                        <table class="level-table custom--table table">
                                            <thead>
                                                <tr>
                                                    <th>@lang('S.N.')</th>
                                                    <th>@lang('Phase Number')</th>
                                                    <th>@lang('Ticket')</th>
                                                    <th>@lang('Result')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse(@$tickets as $ticket)
                                                    <tr>
                                                        <td>{{ $tickets->firstItem() + $loop->index }}</td>
                                                        <td>@lang('Phase ' . $ticket->phase->phase_number)</td>
                                                        <td> {{ $ticket->ticket_number }}</td>
                                                        <td>
                                                            @php
                                                                echo $ticket->statusBadge;
                                                            @endphp
                                                        </td>
                                                    @empty
                                                        <td class="text-center rounded-bottom" colspan="100%">{{ __($emptyMessage) }}</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-center mt-3">
                                            @if ($tickets->hasPages())
                                                {{ paginateLinks($tickets) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endauth

                        </div>
                    </div>
                </div>
            </div><!-- row end -->
        </div>
    </section>

    <!-- Modal -->
    @include($activeTemplate . 'partials.ticket_confirmation_modal')

    <!-- lottery details section end -->
@endsection

@push('script')
    <script type="text/javascript">
        (function($) {
            "use strict";
            var digits = {{$phase->digits}}
            const e = Number(`1e${digits - 1}`);
            const min = e;
            const max = Number(e.toString().replaceAll(1,9).replaceAll(0,9));
            const errorMsg = `Ticket number must be between ${min} and ${max}`
            
            $(window).on('load', function() {
                var element = $('.elements').length;
                addMoreBtn(element);
                
                var inputElements = $('.form-check-input');
                $.each(inputElements, function (index, element) {
                    element = $(element);
                    element.closest('.form-group').find('label').attr('for', element.attr('name'));
                    element.attr('id', element.data('id'))
                });
                $('.numberItem').attr("placeholder",'0'.repeat(digits))
                $('.numberItem').on('input', function() {
                    let val =  $(this).val();
                    $(this).val(val.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1'));
                })
                // CHECK IF TYPE NUMBER 
                $('#unique-numbers .numberItem').on('change', function (e) {
                    const val = $(this).val()
                    if ( val < min || val > max ){
                        $(`#unique-numbers .errMsg`).show();
                        notify('error',errorMsg)
                    } else {
                        $(`#unique-numbers .errMsg`).hide();
                        var tendigitrandom = $(this).val();
                        var array = tendigitrandom.toString().split('');
                        var newArray = [];
                        $.each(array, function(index, value) {
                            newArray[index] = `<span>${value}</span>`;
                        });
                        $(this).parents('#unique-numbers.elements').children('.numbers').html(newArray);
                        $(this).parents('#unique-numbers.elements').children('.numbers').addClass('active');
                        $(this).parents('#unique-numbers.elements').children('.numbers').removeClass('op-0-3');
                        $(this).parents('#unique-numbers.elements').children('.numVal').val(tendigitrandom);
                    }
                });
            });

            $('.addMore').click(function() {
                var element = $('.elements').length + 1
                var html = `
                        <div class="col-xl-4 col-md-6 elem">
                            <div class="ticket-card">
                                <button type="button" class="ticket-card-del removeBtn"><i class="las la-times"></i></button>
                                <div class="ticket-card__header">
                                    <h4>@lang('Your Ticket Number')</h4>
                                </div>
                                <div class="ticket-card__body elements" id="unique-numbers-${element}">
                                    <input type="hidden" class="numVal" name="number[]">
                                    <div id="numbers-${element}" class="number-group numbers uniqueNumbers mb-4"></div>
                                    <div class="form-group uniqueNumbers row ps-3 pe-3" style="display: none;" >
                                        <input class="form-control numberItem col-12"  type="number" />
                                        <span style="display: none; color: red;" class="errMsg col-12 mt-3"></span>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" data-type="unique-numbers-${element}" id="generates1_${element}" type="radio" name="isGenerates${element}" value="true" checked>
                                            <label class="form-check-label" for="generates1_${element}">
                                                Generate number
                                            </label>
                                        </div>
                                    <div class="form-check form-check-inline">
                                        <input value="false" id="generates2_${element}" class="form-check-input"  data-type="unique-numbers-${element}" type="radio" value="false" name="isGenerates${element}">
                                            <label class="form-check-label" for="generates2_${element}">
                                                Enter number
                                            </label>
                                    </div>
                                    <button type="button" class="btn btn-md btn--base w-100 generate" data-type="unique-numbers-${element}">@lang('Generate Number')</button>
                                </div>
                            </div>
                        </div>
                	`;
                $('#tickets').append(html);
                for (let i = 0 ; i < digits; i++) {
                    $(`#numbers-${element}`).append('<span>0</span>')
                }
                $('.numberItem').attr("placeholder",'0'.repeat(digits))
                $('.numberItem').on('input', function() {
                    let val =  $(this).val();
                    $(this).val(val.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1'));
                })
                $('.qnt').html(element);
                $('.tam').html(element * {{ $phase->lottery->price }});
                $('input[name=ticket_quantity]').val(element);
                $('input[name=total_price]').val(element * {{ $phase->lottery->price }});
                randomTicketGenerate();
                remove();
                addMoreBtn(element);
            });

            function remove() {
                $('.removeBtn').click(function() {
                    $(this).parents('.elem').remove();
                    var elem = $('.elements').length;
                    addMoreBtn(elem);
                    $('.qnt').html(elem);
                    $('.tam').html(elem * {{ $phase->lottery->price }});
                    $('input[name=ticket_quantity]').val(elem);
                    $('input[name=total_price]').val(elem * {{ $phase->lottery->price }});
                });
            }

            function addMoreBtn(count) {
                if (count >= {{ $phase->available }}) {
                    $('.addMore').addClass('d-none');
                } else {
                    $('.addMore').removeClass('d-none');
                }

                $(`.errMsg`).html(errorMsg)
                
                $('input[type=radio]').change(function() {
                    let dataType = $(this).data('type');
                    let value = $(this).val();
                    if ( value == "true") {
                        $(`#${dataType} .form-group`).hide();
                        $(`#${dataType} .number-group`).show();
                        $(`#${dataType} .generate`).show();
                    } else {
                        $(`#${dataType} .form-group`).show();
                        $(`#${dataType} .number-group`).hide();
                        $(`#${dataType} .generate`).hide();
                    }
                })

                $(`#unique-numbers-${count} .numberItem`).on('change', function (e) {
                    const val = $(this).val()
                    if ( val < min || val > max ){
                        $(`#unique-numbers-${count} .errMsg`).show();
                        notify('error',errorMsg)
                    } else {
                        $(`#unique-numbers-${count} .errMsg`).hide();
                        var tendigitrandom = $(this).val();
                        var array = tendigitrandom.toString().split('');
                        var newArray = [];
                        $.each(array, function(index, value) {
                            newArray[index] = `<span>${value}</span>`;
                        });
                        $(this).parents(`#unique-numbers-${count}.elements`).children('.numbers').html(newArray);
                        $(this).parents(`#unique-numbers-${count}.elements`).children('.numbers').addClass('active');
                        $(this).parents(`#unique-numbers-${count}.elements`).children('.numbers').removeClass('op-0-3');
                        $(this).parents(`#unique-numbers-${count}.elements`).children('.numVal').val(tendigitrandom);
                    }
                });
            }

            function randomTicketGenerate(elements) {
                $('.generate').click(function() {
                    var randomNum = Math.floor(1 * e + Math.random() * 9 * e);
                    var array = randomNum.toString().split('');
                    var newArray = [];

                    $.each(array, function(index, value) {
                        newArray[index] = `<span>${value}</span>`;
                    });

                    $(this).parents('.elements').children('.numbers').html(newArray);
                    $(this).parents('.elements').children('.numbers').addClass('active');
                    $(this).parents('.elements').children('.numbers').removeClass('op-0-3');
                    $(this).parents('.elements').children('.numVal').val(randomNum);
                    // SET VALUE FOR FORM IF GENERATE 
                    let dataType = $(this).data('type');
                    $(`#${dataType} .errMsg`).hide();
                    $(`#${dataType} .numberItem`).val(randomNum);
                });
            }

            $('.generate').click(function() {
                const e = Number(`1e${digits - 1}`);
                var tendigitrandom = Math.floor(1 * e + Math.random() * 9 * e);
                var array = tendigitrandom.toString().split('');
                var newArray = [];
                $.each(array, function(index, value) {
                    newArray[index] = `<span>${value}</span>`;
                });

                $(this).parents('.elements').children('.numbers').html(newArray);

                $(this).parents('.elements').children('.numbers').addClass('active');
                $(this).parents('.elements').children('.numbers').removeClass('op-0-3');
                $(this).parents('.elements').children('.numVal').val(tendigitrandom);
                // SET VALUE FOR FORM IF GENERATE 
                let dataType = $(this).data('type');
                $(`#${dataType} .errMsg`).hide();
                $(`#${dataType} .numberItem`).val(tendigitrandom);
            });


            $('.buyBtn').on('click', function() {
                let emptyValueCheck = false;
                $.each($('#tickets').find('.numVal'), function(i, val) {
                    if (!val.value) {
                        emptyValueCheck = true;
                    }
                });
                if (emptyValueCheck) {
                    notify('error', 'Ticket number field is required!')
                    return;
                } else {
                    $('.submit-form').find('.buyBtn').html(
                        '<i class="la la-shopping-bag fa-spin"></i> Buy Now');

                    var modal = $('#exampleModal');
                    modal.modal('show');
                    $('.buyTicketConfirmation').on('click', function() {
                        $('.submit-form').submit();
                        modal.modal('show');
                    })

                }

            });

            $('input[type=radio]').change(function() {
                let dataType = $(this).data('type');
                let value = $(this).val();
                if ( value == "true") {
                    $(`#${dataType} .form-group`).hide();
                    $(`#${dataType} .number-group`).show();
                    $(`#${dataType} .generate`).show();
                } else {
                    $(`#${dataType} .form-group`).show();
                    $(`#${dataType} .number-group`).hide();
                    $(`#${dataType} .generate`).hide();
                }
            })
        })(jQuery);
    </script>
@endpush
