<!DOCTYPE html>
<html lang="es_MX">
<!--html lang="{{ str_replace('_', '-', app()->getLocale()) }}"-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Madurai:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.6/dist/vue-multiselect.min.css" />

    <style type="text/css">
        .datatable {
            overflow: auto;
        }


        body {
            font-family: 'Josefin Sans', sans-serif !important;
        }

        table.display tbody {
            font-size: 0.85rem;
            /*font-family: 'Hind Madurai', sans-serif;*/
        }

        .hidden {
            display: none;
        }

        .show {
            display: block;
        }

        table.display tbody tr:hover {
            color: #1590e7;
        }


        .w-100 {
            width: 100% !important;
        }


        label.required::after {
            content: '*';
            color: red;
            margin-left: 0.3rem;
        }

        .text-error {
            color: red;
            font-size: 0.85rem;
            text-align: right;
        }


        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }


        .datatable select {
            min-width: 90px;
            padding-left: 12px;
            padding-right: 32px;
        }

        .dropdown-danger a,
        .dropdown-danger button {
            color: red !important;
        }

        .table-inner {
            border: 1px solid #dbdbdb;
        }

        .table-inner td {
            padding-top: 0.2rem !important;
            padding-bottom: 0.2rem !important;
        }

        td .table-inner {
            margin-top: 0.85rem;
        }

        td .table-inner:nth-child(1) {
            margin-top: 0;
        }

        .multiselect__tags,
        .multiselect__single {
            background-color: rgb(249 250 251) !important;
        }

        .multiselect__single {
            margin-bottom: 9px;
            margin-top: 3px;
        }

        table.dataTable thead {
            background-color: #fed7aa;
        }

        .dataTables_filter {
            margin-bottom: 8px;
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.4/dist/flowbite.min.css" />
    <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead

</head>
{{-- <body class="font-sans antialiased">
        @inertia
    </body> --}}

<body class="font-sans antialiased">
    <div id="app" data-page="{{ json_encode($page) }}"></div>
</body>

</html>
