<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seo Analize</title>
    @vite("resources/css/app.css")
</head>
<body>
    <form action="{{ route("check") }}" method="post" class="flex justify-center items-center p-4 flex-col gap-4">
        @csrf
        <input type="text" class="border-2 h-13 w-200 focus-visible:outline-0 p-2 rounded-2xl border-gray-300" dir="ltr" autofocus name="url" placeholder="Your page address:">
        <button class="border px-4 py-3 rounded-xl bg-orange-600 text-white">Submit</button>
    </form>
    @session('data')
        @php
                $Parsedown = new Parsedown();

                $html = $Parsedown->text($value)
        @endphp
    <pre class="p-4 bg-green-100">{!! $html !!}</pre>
    @endsession
</body>
</html>
