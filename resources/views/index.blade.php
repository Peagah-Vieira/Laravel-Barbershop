<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0IouyQ48J0GbyVILPnHYFsB356GZwSxM&callback=initMap&libraries=&v=weekly" async defer></script>
    <script src="js/main_script.js"></script>
    <script src="https://kit.fontawesome.com/0527a7a8a4.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</head>
<body>
    <div class="services" id="services">
        <div class="wrapper">
            <div class="box_services">
                <div class="header_services">
                    <h2>SERVIÇOS &frasl; PREÇOS</h2>
                </div>

                @foreach ($categories->sortBy('amount') as $category)
                    <div class="container_services" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal">
                        <div class="strings_services">
                            <h3 class="uppercase">{{$category->name}}</h3>
                        </div>
                        <div class="strings_price">
                            <p>R${{$category->amount}}</p>
                        </div>
                    </div>
                @endforeach

                <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                    <div class="relative w-full h-full max-w-md md:h-auto">

                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="authentication-modal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>

                            <div class="px-6 py-6 lg:px-8">
                                <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white text-center">Fazer um Agendamento</h3>
                                <form class="space-y-6" method="post" action="{{url('store-form')}}">
                                    @csrf
                                    <div>
                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Digite seu Nome</label>
                                        <input type="text" name="subject" id="subject" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="John Doe" required>
                                    </div>

                                    <div>
                                        <label for="number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Digite seu Número</label>
                                        <input type="text" name="number" id="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="(22)99843-8864" required>
                                    </div>

                                    <div>
                                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecione o Corte</label>
                                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" id="category" name="category">
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="start" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecione o Dia</label>
                                        <input type="date" name="start" id="start" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                    </div>

                                    <div>
                                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecione o Horário</label>
                                        <input type="time" id="startTime" name="startTime" min="08:00" max="19:00" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observação</label>
                                        <input type="text" name="body" id="body" placeholder="Vou chegar atrasado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                    </div>

                                    <button type="submit" class="w-full text-white bg-yellow-500 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                        Enviar
                                    </button>

                                </form>
                            </div>

                        </div>
                    </div>
                </div> 

            </div>
        </div>
    </div>

    <div class="container_slider" id="portfolio">
        <div class="slider">
            <div class="slider__item">
                <img src="img/1.jpg" alt="">
            </div>
            <div class="slider__item">
                <img src="img/2.jpg" alt="">
            </div>
            <div class="slider__item">
                <img src="img/4.jpg" alt="">
            </div>
            <div class="slider__item">
                <img src="img/6.jpg" alt="">
            </div>
            <div class="slider__item">
                <img src="img/5.jpg" alt="">
            </div>
            <div class="slider__item">
                <img src="img/1.jpg" alt="">
            </div>
            <div class="slider__item">
                <img src="img/2.jpg" alt="">
            </div>
            <div class="slider__item">
                <img src="img/4.jpg" alt="">
            </div>
            <div class="slider__item">
                <img src="img/6.jpg" alt="">
            </div>
            <div class="slider__item">
                <img src="img/5.jpg" alt="">
            </div>
        </div>
    </div>
</body>
</html>