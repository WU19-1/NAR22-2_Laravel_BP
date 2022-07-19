<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eli's Book Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#ab9370',
                        'primary-dark': '#ddc39f',
                        'primary-light': '#7b6544',
                        'secondary': '#212121',
                        'secondary-light': '#484848',
                        'secondary-dark': '#000000'
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div class="flex justify-center items-center h-screen bg-primary">
        <form class="w-1/3 bg-white flex justify-center gap-4 p-8 flex-col" method="post">
            {{csrf_field()}}
            <h1 class="text-black text-3xl text-center font-bold">Register</h1>
            <p class="font-bold">Name</p>
            <input type="text" name="name" class="p-2 border-black border-2 rounded">
            <p class="font-bold">Email</p>
            <input type="text" name="email" class="p-2 border-black border-2 rounded">
            <p class="font-bold">Password</p>
            <input type="password" name="password" class="p-2 border-black border-2 rounded">
            <p class="font-bold">Confirm Password</p>
            <input type="password" name="password_confirmation" class="p-2 border-black border-2 rounded">
            @if($errors->any())
                <div class="font-bold text-red-600">{{$errors->first()}}</div>
            @endif
            <div>Already have an account? Login <a class="text-sky-800 hover:underline" href="/login">here.</a></div>
            <button class="p-2 mt-2 rounded bg-primary hover:bg-primary-light hover:text-white font-bold">Register</button>
        </form>
    </div>
</body>
</html>
