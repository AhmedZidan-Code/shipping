@extends('Web.layouts.master')
@section('styles')
    <style>
        .error-message {
            background-color: #e21b1b;
            /* Main color */
            color: #fff;
            /* Text color */
            font-size: 18px;
            /* Adjust font size */
            font-weight: bold;
            /* Make the text bold */
            text-align: center;
            /* Center the text */
            padding: 10px 20px;
            /* Add some spacing */
            border-radius: 5px;
            /* Rounded corners */
            margin: 20px auto;
            /* Add spacing around the message */
            width: fit-content;
            /* Adjust width to fit the text */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Add a subtle shadow */
            direction: rtl;
            /* Ensure proper alignment for Arabic text */
        }
    </style>
@endsection
@section('content')
    <!-- Page Header Start !-->
    <div class="page-breadcrumb-area page-bg my_effct"
        style="background-image: url('{{ asset('assets/web') }}/images/map.jpeg')">
        <div class="page-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-wrapper w_div">

                        <div class="page-heading flow_titel">
                            <h3 class="page-title">تتبع شحنتك
                            </h3>
                            <p>جميع تحديثات الشحنة ستكون متاحة من خلال هذا الرابط.
                            </p>
                        </div>
                        <div class="search_div">
                            <form action="{{ route('order.tracking') }}">
                                @csrf
                                <input type="number" name="order" class="form-control" id="exampleFormControlInput1"
                                    placeholder="رقم التتبع"
                                    @if (isset($order)) value="{{ $order->id }}" @endif>
                                <div class="svg_div">
                                    <button type="submit" style="background-color: #e21b1b;">
                                        <svg class="svg_search" xmlns="http://www.w3.org/2000/svg" width="18"
                                            height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                        </svg>
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End !-->

    <div class="container">

        <div class="page_cont">
            @if (isset($order))
                <div class="fllow_sec">
                    <div class="upper_cont">
                        <span class="span_num">رقم الشحنه #{{ $order->id }}</span>
                        <h1>حالة الطلب :{{ $status }}</h1>
                        <p>اخر تحديث:
                            {{ carbon\carbon::parse($order->updated_at)->translatedFormat('H:i:s l j F Y') }}</p>
                    </div>

                    <div class="cricle_sec">

                        <ul class="ul_circle">
                            <li
                                class="li_circle {{ in_array($order->status, [
                                    'new',
                                    'converted_to_delivery',
                                    'total_delivery_to_customer',
                                    'partial_delivery_to_customer',
                                    'not_delivery',
                                    'under_implementation',
                                    'cancel',
                                    'delaying',
                                    'collection',
                                    'paid',
                                    'shipping_on_messanger',
                                ])
                                    ? 'status_bg'
                                    : '' }}">
                                <div class="svg_circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24" color="#000000" fill="none">
                                        <path d="M8 16L16.7201 15.2733C19.4486 15.046 20.0611 14.45 20.3635 11.7289L21 6"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M6 6L7.5 6M22 6H19" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" />
                                        <path d="M10.5 7C10.5 7 11.5 7 12.5 9C12.5 9 15.6765 4 18.5 3" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="6" cy="20" r="2" stroke="currentColor"
                                            stroke-width="1.5" />
                                        <circle cx="17" cy="20" r="2" stroke="currentColor"
                                            stroke-width="1.5" />
                                        <path d="M8 20L15 20" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" />
                                        <path
                                            d="M2 2H2.966C3.91068 2 4.73414 2.62459 4.96326 3.51493L7.93852 15.0765C8.08887 15.6608 7.9602 16.2797 7.58824 16.7616L6.63213 18"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>

                                <h5><span>تم استلام الطلب
                                    </span><span>{{ carbon\carbon::parse($order->created_at)->translatedFormat('l j F Y') }}
                                    </span></h5>
                            </li>
                            <li
                                class="li_circle {{ in_array($order->status, [
                                    'new',
                                    'converted_to_delivery',
                                    'total_delivery_to_customer',
                                    'partial_delivery_to_customer',
                                    'not_delivery',
                                    'under_implementation',
                                    'cancel',
                                    'delaying',
                                    'collection',
                                    'paid',
                                    'shipping_on_messanger',
                                ])
                                    ? 'status_bg'
                                    : '' }}">
                                <div class="svg_circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24" color="#000000" fill="none">
                                        <path
                                            d="M12 22C11.1818 22 10.4002 21.6698 8.83693 21.0095C4.94564 19.3657 3 18.5438 3 17.1613C3 16.7742 3 10.0645 3 7M12 22C12.8182 22 13.5998 21.6698 15.1631 21.0095C19.0544 19.3657 21 18.5438 21 17.1613V7M12 22L12 11.3548"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M8.32592 9.69138L5.40472 8.27785C3.80157 7.5021 3 7.11423 3 6.5C3 5.88577 3.80157 5.4979 5.40472 4.72215L8.32592 3.30862C10.1288 2.43621 11.0303 2 12 2C12.9697 2 13.8712 2.4362 15.6741 3.30862L18.5953 4.72215C20.1984 5.4979 21 5.88577 21 6.5C21 7.11423 20.1984 7.5021 18.5953 8.27785L15.6741 9.69138C13.8712 10.5638 12.9697 11 12 11C11.0303 11 10.1288 10.5638 8.32592 9.69138Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M6 12L8 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M17 4L7 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>

                                <h5><span>تجهيز الطلب
                                    </span><span>{{ carbon\carbon::parse($order->updated_at)->translatedFormat('l j F Y') }}
                                    </span></h5>
                            </li>
                            <li
                                class="li_circle {{ in_array($order->status, [
                                    'converted_to_delivery',
                                    'total_delivery_to_customer',
                                    'partial_delivery_to_customer',
                                    'not_delivery',
                                    'under_implementation',
                                    'cancel',
                                    'delaying',
                                    'collection',
                                    'paid',
                                    'shipping_on_messanger',
                                ])
                                    ? 'status_bg'
                                    : '' }}">
                                <div class="svg_circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24" color="#000000" fill="none">
                                        <path
                                            d="M19.5 17.5C19.5 18.8807 18.3807 20 17 20C15.6193 20 14.5 18.8807 14.5 17.5C14.5 16.1193 15.6193 15 17 15C18.3807 15 19.5 16.1193 19.5 17.5Z"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <path
                                            d="M9.5 17.5C9.5 18.8807 8.38071 20 7 20C5.61929 20 4.5 18.8807 4.5 17.5C4.5 16.1193 5.61929 15 7 15C8.38071 15 9.5 16.1193 9.5 17.5Z"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <path
                                            d="M14.5 17.5H9.5M2 4H12C13.4142 4 14.1213 4 14.5607 4.43934C15 4.87868 15 5.58579 15 7V15.5M15.5 6.5H17.3014C18.1311 6.5 18.5459 6.5 18.8898 6.6947C19.2336 6.8894 19.4471 7.2451 19.8739 7.95651L21.5725 10.7875C21.7849 11.1415 21.8911 11.3186 21.9456 11.5151C22 11.7116 22 11.918 22 12.331V15C22 15.9346 22 16.4019 21.799 16.75C21.6674 16.978 21.478 17.1674 21.25 17.299C20.9019 17.5 20.4346 17.5 19.5 17.5M2 13V15C2 15.9346 2 16.4019 2.20096 16.75C2.33261 16.978 2.52197 17.1674 2.75 17.299C3.09808 17.5 3.56538 17.5 4.5 17.5"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M2 7H8M2 10H6" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>

                                <h5><span> خارج للتوصيل

                                    </span><span>{{ carbon\carbon::parse($order->converted_date)->translatedFormat('l j F Y') }}
                                    </span></h5>
                            </li>
                            <li
                                class="li_circle {{ in_array($order->status, [
                                    'total_delivery_to_customer',
                                    'partial_delivery_to_customer',
                                    'not_delivery',
                                    'under_implementation',
                                    'cancel',
                                    'delaying',
                                    'collection',
                                    'paid',
                                    'shipping_on_messanger',
                                ])
                                    ? 'status_bg'
                                    : '' }}">
                                <div class="svg_circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24" color="#000000" fill="none">
                                        <path d="M5 14L8.5 17.5L19 6.5" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>

                                <h5><span>
                                        @if (in_array($order->status, [
                                                'total_delivery_to_customer',
                                                'partial_delivery_to_customer',
                                                'not_delivery',
                                                'under_implementation',
                                                'cancel',
                                                'delaying',
                                                'collection',
                                                'paid',
                                                'shipping_on_messanger',
                                            ]))
                                            {{ $status }}
                                        @else
                                            تم التوصيل
                                        @endif

                                    </span><span>{{ carbon\carbon::parse($order->converted_date)->translatedFormat('l j F Y') }}
                                    </span></h5>
                            </li>

                        </ul>
                    </div>
                </div>

                <button class="show_more">عرض المزيد من التفاصيل</button>

                <table id="customers">
                    <tr>
                        <th>عنصر1</th>
                        <th>عنصر2</th>
                        <th>عنصر3</th>
                    </tr>
                    <tr>
                        <td>التفاصيل</td>
                        <td>التفاصيل</td>
                        <td>التفاصيل</td>
                    </tr>
                    <tr>
                        <td>التفاصيل</td>
                        <td>التفاصيل</td>
                        <td>التفاصيل</td>
                    </tr>
                    <tr>
                        <td>التفاصيل</td>
                        <td>التفاصيل</td>
                        <td>التفاصيل</td>
                    </tr>
                    <tr>
                        <td>التفاصيل</td>
                        <td>التفاصيل</td>
                        <td>التفاصيل</td>
                    </tr>
                    <tr>
                        <td>التفاصيل</td>
                        <td>التفاصيل</td>
                        <td>التفاصيل</td>
                    </tr>



                </table>
            @else
                <div class="error-message">
                    أدخل رقم شحنة صالح من فضلك
                </div>
            @endif
        </div>





    </div>
@endsection
