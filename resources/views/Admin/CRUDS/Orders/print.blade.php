<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة</title>

    <!-- start css styles -->
    <style type="text/css">
        body {
            font-family: sans-serif;
            direction: rtl;
            text-transform: capitalize;
        }


        .box {
            padding: 10px;
        }

        ul {
            padding: 0;
            list-style: none;
            margin: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .header li {
            width: 100%;
        }

        .header li:last-child {
            text-align: left;
        }

        .header li:last-child p {
            flex-direction: row-reverse;
        }

        .header li p {
            font-size: 15px;
            margin-top: 0;
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 5px;
        }

        .header li.logo img {
            height: 50px;
            margin-bottom: 3px;
            border-radius: 7px;
            object-fit: contain;
            max-width: 200px;
        }


        .font-lg {
            font-size: 19px !important;
            width: 85%;
            line-height: 17px;
        }

        .flex-col {
            display: flex;
            flex-direction: column;
            gap: 15px;
            justify-content: space-between;
            height: 100%;
            position: relative;
            justify-content: center;
            max-width: 1300px;
            margin: auto;

        }

        h3,
        h2,
        h1,
        h5,
        p {
            margin: 0;
        }

        .fatora_sec {
            border: 3px solid #000;
            position: relative;
            border-radius: 15px;

        }

        .fatora_sec::after {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            content: "";
            background-image: url({{ asset('assets/print/image/apple-logo.svg') }});
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.1;
            z-index: -1 !important;
        }

        .flex_fatora_header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 10px 12px 10px;
            gap: 20px;
            border-bottom: 3px solid #000;
        }

        .right_cont {
            display: flex;
            align-items: center;
            gap: 35px;
            width: 35%;
        }

        .right_cont h2 {
            color: #e5313e;
        }

        .flex_fatora_header .first {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .first img {
            height: 100px;
        }

        .flex_fatora_header .first .social_icons {
            display: flex;
            align-items: center;
            flex-direction: column;
            gap: 5px;
        }

        .flex_fatora_header .first .social_icons svg {
            background: #000;
            width: 20px;
            height: 20px;
            padding: 2px;
            border-radius: 4px;
        }

        .second {
            width: 25%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .second h2 span {
            font-size: 22px;
            min-width: max-content;
        }

        .second h2 {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            color: #000;
        }

        .second h2 .posla {
            font-size: 30px;
            font-weight: 700;
        }

        .third h5 {
            display: flex;
            flex-direction: column;
            border: 2px solid #000;
            gap: 0px;
            border-radius: 25px;
            color: #000;
            overflow: hidden;
        }


        .spn_trip {
            font-size: 25px;
            font-weight: 700;
            border-bottom: 2px solid #000;
            width: 100%;
            padding: 5px 30px;
            display: flex;
            align-items: center;
            text-align: center;
            background: #a7a8a394;
        }

        .spn_trip2 {
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            text-align: center;
            justify-content: center;
            padding: 0px 30px;
            height: 60px;
        }

        .third {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 20px;
            width: 35%;
            justify-content: flex-end;
        }


        .fatora_body {
            padding: 12px 10px 12px 10px;
            display: flex;
            gap: 10px;

        }

        .right_side {
            width: calc(100% - 210px);
        }

        .right_side .flex-div {
            display: flex;
            align-items: center;
            gap: 10PX;
        }

        .right_side .flex-div.tow {
            margin-top: 10px;

        }

        .right_side .flex-div.three {
            margin-top: 10px;
        }


        .right_side h5 {
            width: 33.33%;
            display: flex;
            align-items: center;
            border: 2px solid #000;
            border-radius: 10px;
            font-size: 18px;
            color: #000;
            overflow: hidden;
        }

        .right_side h5 span {
            padding-right: 10px;
        }

        .right_side h5 .f5_spn {
            border-left: 2px solid #000;
            padding: 10px;
            font-size: 19px;
            background: #ccccca;
            width: 130px;
            text-align: center;
        }

        .span_add {
            height: 80px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .three_elment p span {
            padding: 0;
        }

        .number_h5 {
            width: 33.33% !important;
        }

        .adders_h5 {
            width: 68% !important;
        }


        .marks {
            width: 100%;
            margin-top: 10px;
            border: 2px solid #000;
            border-radius: 15px;
            overflow: hidden;
        }

        .marks h4 {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .marks h4 span {
            border-bottom: 2px solid #000;
            width: 100%;
            text-align: center;
            padding: 4px 0px;
            font-size: 23px;
            font-weight: 700;
            background: #ccccca;
        }

        .marks h4 .titleing {
            border-bottom: 0;
            text-align: right;
            padding-right: 15px;
            height: 45px;
            background: unset !important;
            display: flex;
            align-items: center;
        }

        .left_side {
            width: 200px;
            min-width: 200px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .left_side h4 {
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border: 2px solid #000;
            border-radius: 19px;
            overflow: hidden;

        }


        .left_side h4 .sender {
            font-size: 24px;
            padding: 4px 0px;
            border-bottom: 2px solid #000;
            width: 100%;
            text-align: center;
            background: #ccccca;
        }



        .left_side h4 .content {
            text-align: right;
            justify-content: flex-start;
            width: 100%;
            padding-right: 15px;
            height: 60px;
            display: flex;
            align-items: center;
            font-size: 18px;
        }

        .left_side h4 .content.hight_span {
            height: 287px;
        }


        .adders_h5.higth_h {
            height: 70px;
            position: relative;

        }

        .three_elment {
            position: absolute;
            left: 0;
            top: 0;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .three_elment li {
            display: flex;
            flex-direction: column;
            align-items: center;
            border-right: 2px solid #000;
            height: 100%;
            width: 60px;
        }

        .three_elment .span_name {
            padding: 0;
            border-bottom: 2px solid #000;
            width: 100%;
            text-align: center;
        }

        .three_elment .span_space {
            padding: 0;
        }

        .fatora_fotter {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 100px;
            border-top: 3px solid #000;
            padding: 5px 0px;
        }

        .fatora_fotter p {
            font-size: 21px;
            font-weight: 600;
        }

        .fatora_fotter .p_number {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 20px;
            font-weight: 600;

        }

        .btn_print {
            width: max-content;
            display: flex;
            align-items: center;
            justify-content: center;
            inset: 0;
            margin: auto;
            font-size: 20px;
            padding: 10px 50px;
            border: none;
            background: #4CAF50;
            color: #fff;
            border-radius: 3px;
            font-weight: 600;
            transition: 0.3s all;
            cursor: pointer;
        }

        .btn_print:hover {
            background: #357937;
        }


        @media print {
            .btn_print {
                display: none !important;
            }
        }

        @media print {
            .box {
                break-inside: avoid;
                page-break-inside: avoid;
            }

            .box:nth-child(2n) {
                page-break-after: always;
            }
        }
    </style>


    <!-- end css styles -->

</head>

<body>
    @foreach ($orders as $order)
        <div class="flex-col">
            <div class="box mb-3">
                <div class="fatora_sec">
                    <div class="flex_fatora_header">
                        <div class="right_cont">
                            <div class="first">
                                {{-- <img src="{{ asset('assets/print/') }}/image/QR_code_for_mobile_English_Wikipedia.svg.png"> --}}
                                {!! QrCode::size(80)->generate(route('order.tracking', ['order' => $order->id])) !!}
                                <div class="social_icons" style="margin-right: 10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24" color="#ffffff" fill="none">
                                        <path
                                            d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                        <path
                                            d="M16.5 12C16.5 14.4853 14.4853 16.5 12 16.5C9.51472 16.5 7.5 14.4853 7.5 12C7.5 9.51472 9.51472 7.5 12 7.5C14.4853 7.5 16.5 9.51472 16.5 12Z"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <path d="M17.5078 6.5L17.4988 6.5" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24" color="#ffffff" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.18182 10.3333C5.20406 10.3333 5 10.5252 5 11.4444V13.1111C5 14.0304 5.20406 14.2222 6.18182 14.2222H8.54545V20.8889C8.54545 21.8081 8.74951 22 9.72727 22H12.0909C13.0687 22 13.2727 21.8081 13.2727 20.8889V14.2222H15.9267C16.6683 14.2222 16.8594 14.0867 17.0631 13.4164L17.5696 11.7497C17.9185 10.6014 17.7035 10.3333 16.4332 10.3333H13.2727V7.55556C13.2727 6.94191 13.8018 6.44444 14.4545 6.44444H17.8182C18.7959 6.44444 19 6.25259 19 5.33333V3.11111C19 2.19185 18.7959 2 17.8182 2H14.4545C11.191 2 8.54545 4.48731 8.54545 7.55556V10.3333H6.18182Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                    </svg>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24" color="#ffffff" fill="none">
                                        <path
                                            d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 13.3789 2.27907 14.6926 2.78382 15.8877C3.06278 16.5481 3.20226 16.8784 3.21953 17.128C3.2368 17.3776 3.16334 17.6521 3.01642 18.2012L2 22L5.79877 20.9836C6.34788 20.8367 6.62244 20.7632 6.87202 20.7805C7.12161 20.7977 7.45185 20.9372 8.11235 21.2162C9.30745 21.7209 10.6211 22 12 22Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                        <path
                                            d="M8.58815 12.3773L9.45909 11.2956C9.82616 10.8397 10.2799 10.4153 10.3155 9.80826C10.3244 9.65494 10.2166 8.96657 10.0008 7.58986C9.91601 7.04881 9.41086 7 8.97332 7C8.40314 7 8.11805 7 7.83495 7.12931C7.47714 7.29275 7.10979 7.75231 7.02917 8.13733C6.96539 8.44196 7.01279 8.65187 7.10759 9.07169C7.51023 10.8548 8.45481 12.6158 9.91948 14.0805C11.3842 15.5452 13.1452 16.4898 14.9283 16.8924C15.3481 16.9872 15.558 17.0346 15.8627 16.9708C16.2477 16.8902 16.7072 16.5229 16.8707 16.165C17 15.8819 17 15.5969 17 15.0267C17 14.5891 16.9512 14.084 16.4101 13.9992C15.0334 13.7834 14.3451 13.6756 14.1917 13.6845C13.5847 13.7201 13.1603 14.1738 12.7044 14.5409L11.6227 15.4118"
                                            stroke="currentColor" stroke-width="1.5" />
                                    </svg>
                                </div>
                            </div>
                            <h2>{{ $order->id }}</h2>
                        </div>
                        <div class="second">
                            <h2><span class="posla">بوصلة</span><span>وصلت لكل بيت في مصر</span></h2>
                        </div>
                        <div class="third">
                            <h5><span class="spn_trip">الاجمالي</span><span
                                    class="spn_trip2">{{ $order->total_value }}</span></h5>
                            <img style="max-width: 100px; max-height:100px;"
                                src="{{ asset('assets/print/') }}/image/Bosla.png">

                        </div>
                    </div>

                    <div class="fatora_body">
                        <div class="right_side">
                            <div class="flex-div tow">
                                <h5 class="adders_h5 higth_h">
                                    <span class="f5_spn">المرسل الية</span>
                                    <span>{{ $order->customer_name ?? '' }}</span>
                                </h5>

                                <h5 class="adders_h5 higth_h">
                                    <span class="f5_spn">المحافظة</span>
                                    <span>
                                        @if ($order->province)
                                            {{ optional($order->province->country)->title ?? $order->province->title }}
                                        @endif
                                    </span>
                                </h5>

                            </div>
                            <div class="flex-div tow">
                                <h5 class="adders_h5 higth_h">
                                    <span class="f5_spn">المدينة</span>
                                    <span>
                                        @if ($order->province)
                                            {{ $order->province->title }}
                                        @endif
                                    </span>
                                </h5>
                                <h5 class="adders_h5 higth_h">
                                    <span class="f5_spn">التليفون</span>
                                    <span>
                                        {{ $order->customer_phone }}
                                    </span>
                                </h5>
                            </div>
                            <div class="flex-div three">

                                <h5 class="adders_h5 higth_h">
                                    <span class="f5_spn span_add">العنوان</span>
                                    <span>
                                        {{ $order->customer_address }}
                                    </span>
                                </h5>
                                <h5 class="adders_h5 higth_h">
                                    <span class="f5_spn">عدد القطع</span>
                                    <span></span>
                                </h5>

                            </div>
                            <div class="flex-div three">

                                <h5 class="adders_h5 higth_h">
                                    <span class="f5_spn">السماح بفتح الشحنة</span>
                                    <span></span>
                                </h5>

                                <h5 class="adders_h5 higth_h">
                                    <span class="f5_spn">قابلة للكسر</span>
                                    <span></span>
                                </h5>
                            </div>

                            <div class="marks">
                                <h4><span>الملاحظات</span><span class="titleing"></span></h5>
                            </div>
                        </div>

                        <div class="left_side">
                            <h4><span class="sender">الراسل</span><span class="content">
                                    @if ($order->trader)
                                        {{ $order->trader->name ?? '' }}
                                    @endif
                                </span></h4>
                            <h4><span class="sender">وصف الشحن</span><span class="content hight_span"></span></h4>

                        </div>
                    </div>

                    <div class="fatora_fotter">
                        <p>{{ $settings->address }}</p>
                        <p class="p_number"><span>{{ $settings->phones }}</span></p>
                    </div>


                </div>
            </div>
        </div>
    @endforeach



    <script>
        document.getElementById('btn_print').addEventListener('click', function() {
            window.print();
        });
    </script>


</body>

</html>
