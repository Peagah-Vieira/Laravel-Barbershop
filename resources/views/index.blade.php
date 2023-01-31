<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mt-4">
        <div class="card">

          <div class="card-header text-center font-weight-bold">
            Laravel 9 - Criação de um agendamento 
          </div>

          <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('store-form')}}">
                @csrf
                <div class="form-group">
                    <label>Título</label>
                    <input type="text" id="subject" name="subject" class="form-control">
                </div>

                <div class="form-group">
                    <label>Mensagem</label>
                    <input type="text" id="body" name="body" class="form-control">
                </div>

                <div class="form-group">
                    <label>Categoria</label>
                    <select id="category" name="category">
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Começo</label>
                    <input type="date" id="start" name="start">
                    <input type="time" id="startTime" name="startTime">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div> 
</body>
</html>