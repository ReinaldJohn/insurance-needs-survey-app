<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Pascal Burke">
    <title>Thank You! | Pascal Burke Insurance Brokerage Inc.</title>

    <!-- Favicons-->


    <!-- YOUR CUSTOM CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html,
        body {
        height: 100%;
        }

        html * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        }

        body {
        background: #fff;
        font-size: 0.875rem;
        line-height: 1.4;
        font-family: "Work Sans", Arial, sans-serif;
        color: #555;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
        color: #222;
        }

        p {
        margin-bottom: 25px;
        }

        strong {
        font-weight: 500;
        }

        label {
        font-weight: 400;
        margin-bottom: 3px;
        color: #222;
        }

        hr {
        margin: 30px 0 30px 0;
        border-color: #ddd;
        }

        ul, ol {
        list-style: none;
        margin: 0 0 25px 0;
        padding: 0;
        }




        /*-------- 1.3 Structure --------*/
        /*-------- Preloader --------*/
        #preloader {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        bottom: 0;
        background-color: #fff;
        z-index: 99999999999 !important;
        }

        [data-loader="circle-side"] {
        position: absolute;
        width: 50px;
        height: 50px;
        top: 50%;
        left: 50%;
        margin-left: -25px;
        margin-top: -25px;
        -webkit-animation: circle infinite .95s linear;
        -moz-animation: circle infinite .95s linear;
        -o-animation: circle infinite .95s linear;
        animation: circle infinite .95s linear;
        border: 2px solid #f7274a;
        border-top-color: rgba(0, 0, 0, 0.2);
        border-right-color: rgba(0, 0, 0, 0.2);
        border-bottom-color: rgba(0, 0, 0, 0.2);
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        border-radius: 100%;
        }

        #loader_form {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        bottom: 0;
        background-color: #fafafa;
        background-color: rgba(255, 255, 255, 0.6);
        z-index: 99999999999 !important;
        display: none;
        }

        [data-loader="circle-side-2"] {
        position: absolute;
        width: 50px;
        height: 50px;
        top: 50%;
        left: 50%;
        margin-left: -25px;
        margin-top: -25px;
        -webkit-animation: circle infinite .95s linear;
        -moz-animation: circle infinite .95s linear;
        -o-animation: circle infinite .95s linear;
        animation: circle infinite .95s linear;
        border: 2px solid #f7274a;
        border-top-color: rgba(0, 0, 0, 0.2);
        border-right-color: rgba(0, 0, 0, 0.2);
        border-bottom-color: rgba(0, 0, 0, 0.2);
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        border-radius: 100%;
        }

        @-webkit-keyframes circle {
        0% {
            -webkit-transform: rotate(0);
            -moz-transform: rotate(0);
            -ms-transform: rotate(0);
            -o-transform: rotate(0);
            transform: rotate(0);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
        }
        @-moz-keyframes circle {
        0% {
            -webkit-transform: rotate(0);
            -moz-transform: rotate(0);
            -ms-transform: rotate(0);
            -o-transform: rotate(0);
            transform: rotate(0);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
        }
        @-o-keyframes circle {
        0% {
            -webkit-transform: rotate(0);
            -moz-transform: rotate(0);
            -ms-transform: rotate(0);
            -o-transform: rotate(0);
            transform: rotate(0);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
        }
        @keyframes circle {
        0% {
            -webkit-transform: rotate(0);
            -moz-transform: rotate(0);
            -ms-transform: rotate(0);
            -o-transform: rotate(0);
            transform: rotate(0);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
        }

        /*============================================================================================*/
        /* 2.  CONTENT */
        /*============================================================================================*/
        /*-------- 2.1 Wizard --------*/


        /*-------- 2.2 Success submit --------*/
        #success {
            position: absolute;
            top: 30%;
            left: 50%;
            width: 1200px;
            height: 190px;
            margin-top: -95px;   /* half of the height */
            margin-left: -600px; /* half of the width */
            text-align: center;
        }
        #success h3 {
            text-transform: uppercase;
            color: #064367;
            font-family: 'Montserrat', sans-serif;
            letter-spacing: 3px;
            margin-bottom: 10px; /* added this to give spacing below the h3 */
            font-size:45px;
        }
        #success h4 {
            font-family: 'Nunito', sans-serif;
            /* font-weight: 400; */
            margin: 20px 0 0 0;
            font-size: 30px;
            margin-bottom: 10px; /* added this to give spacing below the h3 */
        }
        #success h4 span {
        display: block;
        margin-bottom: 0;
        font-weight: 500;
        font-size: 21px;
        font-size: 1.3125rem;
        }

        @-webkit-keyframes checkmark {
        0% {
            stroke-dashoffset: 50px;
        }
        100% {
            stroke-dashoffset: 0;
        }
        }
        @-ms-keyframes checkmark {
        0% {
            stroke-dashoffset: 50px;
        }
        100% {
            stroke-dashoffset: 0;
        }
        }
        @keyframes checkmark {
        0% {
            stroke-dashoffset: 50px;
        }
        100% {
            stroke-dashoffset: 0;
        }
        }
        @-webkit-keyframes checkmark-circle {
        0% {
            stroke-dashoffset: 240px;
        }
        100% {
            stroke-dashoffset: 480px;
        }
        }
        @-ms-keyframes checkmark-circle {
        0% {
            stroke-dashoffset: 240px;
        }
        100% {
            stroke-dashoffset: 480px;
        }
        }
        @keyframes checkmark-circle {
        0% {
            stroke-dashoffset: 240px;
        }
        100% {
            stroke-dashoffset: 480px;
        }
        }
        .inlinesvg .svg svg {
        display: inline;
        }

        .icon--order-success svg path {
        -webkit-animation: checkmark 0.25s ease-in-out 0.7s backwards;
        animation: checkmark 0.25s ease-in-out 0.7s backwards;
        }

        .icon--order-success svg circle {
        -webkit-animation: checkmark-circle 0.6s ease-in-out backwards;
        animation: checkmark-circle 0.6s ease-in-out backwards;
        }

        .c-body {
            padding: 20px;
            display: inline;
        }
        .c-container {
            margin: auto;
            width: 100%;
            padding: 10px;
        }
        .c-information {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            margin-top: 30px;
        }
        .c-information p {
            width: 800px;
            margin: auto;
            font-size:22px;
            font-family: 'Nunito', sans-serif;
        }
        .c-btn {
            margin-top: 40px;
            border-radius: 50px;
            padding: 20px;
            text-transform: uppercase;
            background-color: #0170A8;
            color: #ffffff;
            border:none;
            font-size:24px;
            transition: 0.3s;
            cursor: pointer
        }
        .c-btn a {
            color: #ffffff;
            text-decoration: none;
        }
        .c-btn:hover {
            background-color: #3998D9;

        }
        .c-logo {
            width:auto;
            height:auto;
        }

    </style>
</head>

<body class="c-body">
    <div id="success">
        <div class="c-container">
            <div class="icon icon--order-success svg">
                <img src="{{ asset('img/thank-you-insurance-survey.webp') }}" alt="" srcset="" class="c-logo">
            </div>
            <button class="c-btn" id="go-back"><a href="https://pbibins.com"> Go Back To the Website </a></button>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</html>
