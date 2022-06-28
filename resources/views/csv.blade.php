<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <!--A few headers to manage potential risks on public facing site-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Security-Policy" content="default-src *; style-src 'self' script-src 'self'"/>
        <meta http-equiv="Strict-Transport-Security" content="max-age=31536000; includeSubDomains; preload">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv='X-XSS-Protection' content='1'>
        <meta name="referrer" content="strict-origin-when-cross-origin">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex,nofollow">
        <meta name="X-Frame-Options" content="DENY">
        <title>Laravel</title>
        <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
    </head>
    <!--Simple body to present resulting application of test-->
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-2">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img src="/img/devprox-logo.png">
                </div>
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold">Create a CSV File</div>
                            </div>
                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    <strong><ul><a href="/build-csv">Submit here to generate the file at public/output/output.csv</a></ul></strong>
                                    <form action="/build-csv", method="POST">
                                       {!! csrf_field() !!}
                                      <input type="number" name="nrRows" placeholder="1000000">
                                      <input type="submit" value="Create CSV File">
                                    </form>
                                    <?php if (file_exists('output/output.csv')){ ?>
                                    <br>
                                    <br>
                                    <a href="/remove-csv">Click here to remove the file at public/output/output.csv</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                            <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                              <div class="ml-4 text-lg leading-7 font-semibold">Import CSV</div>
                              <br>
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li style="color:red">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <br>
                                 @endif
                              <div class="flex items-center">

                                 <form action="/process-csv", method="POST" enctype="multipart/form-data">
                                       {!! csrf_field() !!}
                                      <input type="file" name="csvFile" placeholder="1000000">
                                      <input type="submit" value="Submit CSV">
                                </form>
                            </div>
                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm"></div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
