<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="\Abrigo\assets\css\output.css" rel="stylesheet">
  <title>document</title>
</head>
<body>

  <nav class="h-20 bg-CremeEscuro flex items-center justify-around ">
    <div class="logo h-16 mr-36 w-16  bg-amber-300 lg:ml-1">
      <img class="h-16 w-16 justify-self-center" src="https://picsum.photos/200 " alt="" srcset="">
    </div>

    <!-- nav mobile -->
    <button id="hamburger" class="hamburger h-16 w-10 bg-blue-000 flex flex-col items-center justify-center md:hidden">
      <span></span>
      <span></span>
      <span></span>
    </button>
    
    <div id="menu" class="absolute top-20 left-0 w-full bg-CremeEscuro flex flex-col items-center hidden">
      <a href="#" class="py-2">Lorem Ipsium</a>
      <a href="#" class="py-2">Lorem Ipsium</a>
      <a href="#" class="py-2">Lorem Ipsium</a>
      <a href="#" class="py-2">Lorem Ipsium</a>
      <a href="#" class="py-2">Lorem Ipsium</a>
    </div>
    <!-- nav que num é mobile -->
    <div class="links hidden md:flex justify-center align-items-center lg:mx-20">
      <ul class="md:flex md:gap-5 ">
        <li>
          <a class="" href="">Lorem Ipsium</a>
        </li>
        <li>
          <a href="">Lorem Ipsium</a>
        </li>
        <li>
          <a href="">Lorem Ipsium</a>
        </li>
        <li>
          <a href="">Lorem Ipsium</a>
        </li>      
        <li>
          <a href="">Lorem Ipsium</a>
        </li>                        
      </ul>
    </div>
    <button class="hidden md:flex button h-10 w-20 bg-green-500 lg:mr-30"></button>
  </nav>

  <header class="bg-Creme">
    <img class="flex h-80 w-lvw justify-self-center color" 
    src="/Abrigo/assets/img/veio.png " alt="" srcset="">
    <section class=" w-3/4 mx-7 mt-3 bg-pink-000"> 
      <h1 class="tituloMobile text-CremeEscuro ">Há mais de 30 anos <br> 
      <h2 class="textoMobile  text-CremeEscuro">acolhendo vidas com amor e dignidade</h2>
      </h1>
    </section>
  </header>



  <script src="/Abrigo/assets/js/btn.js"></script>
</body>
</html>