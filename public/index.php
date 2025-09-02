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

    <!-- Seção com o texto inicial -->
    <div class=" w-4/5 mx-7 mt-3 bg-pink-000"> 
      <h1 class="tituloMobile text-CremeEscuro2">Há mais de 30 anos <br> 
      <h2 class="subtituloMobile text-CremeEscuro2 mb-12">acolhendo vidas com amor e dignidade</h2>
      </h1>
      <p class="textoMobile text-CremeEscuro2" >
        O <span class="textoMobileSelecionado">Abrigo São Francisco de Assis</span> nasceu com a missão de oferecer cuidado,
        proteção e qualidade de vida para pessoas idosas em situação de vulnerabilidade.
        Nossa casa é mais do que um espaço físico: é um lar onde cada idoso encontra <span class="textoMobileSelecionado">carinho, segurança e respeito</span>.</p>
        <p class="textoMobile text-CremeEscuro2">
        Atuamos diariamente para garantir alimentação saudável, assistência à saúde, atividades sociais e muito afeto, 
        sempre pautados pela transparência e pelo compromisso com a comunidade </p>
      </p>

      <!-- Botão "Fazer doação" -->
      <div class="ml-4 botao inline-block ">
        <div class="my-2 bg-CremeEscuro h-[1px] w-9/10 justify-self-center"></div>
        <button class="textoBotao text-CremeEscuro2 bg-green-000">Fazer doação</button>
        <div class="my-2 bg-CremeEscuro h-[1px] w-9/10 justify-self-center"></div>
      </div>
      </div>

      <!-- EU ODEIO ESSES CARDS PUTA QUE O PARIU, JA PERDI A CONTA DE QUANTAS VEZES EU TIVE QUE VOLTAR AQUI RESOLVER ALGUMA MERDA. PUTA QUE O PARIU -->
    <div class="cards flex flex-col gap-6 justify-items-center justify-center items-center">
        <div class="card">
          <div class="badge ">
          <svg xmlns="http://www.w3.org/2000/svg" 
            class="badgetexture"
            viewBox="0 0 60 60" 
            preserveAspectRatio="xMidYMid meet">
            <path d="M 0,0 L 60,0 L 46,5 L 46,40 A 24,19 0,0,1 0,40 L 0,0 Z" fill="currentColor"/>
          </svg>
            <svg xmlns="http://www.w3.org/2000/svg" 
              class="icons" 
              fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>

          </div>
          <h1 class="">+30 anos de historia</h1>
          <p class="">Experiencia e tradição no cuidado com pessoas idosas</p>
        </div>
        <div class="card">
          <div class="badge ">
          <svg xmlns="http://www.w3.org/2000/svg" 
            class="badgetexture"
            viewBox="0 0 60 60" 
            preserveAspectRatio="xMidYMid meet">
            <path d="M 0,0 L 60,0 L 46,5 L 46,40 A 24,19 0,0,1 0,40 L 0,0 Z" fill="currentColor"/>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" 
            class="icons" 
            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
          </div>
          <div class="items-center justify-center">
            <h1 class="">+30 anos de historia</h1>
            <p class="">Experiencia e tradição no cuidado com pessoas idosas</p>
          </div>
        </div>
        <div class="card">
          <div class="badge ">
          <svg xmlns="http://www.w3.org/2000/svg" 
            class="badgetexture"
            viewBox="0 0 60 60" 
            preserveAspectRatio="xMidYMid meet">
            <path d="M 0,0 L 60,0 L 46,5 L 46,40 A 24,19 0,0,1 0,40 L 0,0 Z" fill="currentColor"/>
          </svg>
            <svg xmlns="http://www.w3.org/2000/svg" 
                class="icons" 
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M12 21c-4.418 0-8-3.582-8-8V7a2 2 0 0 1 2-2h1l1 5h2V5h2v5h2l1-5h1a2 2 0 0 1 2 2v6c0 4.418-3.582 8-8 8z"/>
            </svg>
          </div>
          <h1 class="">+30 anos de historia</h1>
          <p class="">Experiencia e tradição no cuidado com pessoas idosas</p>
        </div>
    </div>
  </header>

  <section class=" bg-gray-100">
    <h1 class="tituloSec py-10 text-center">Historias que inspiram</h1>

    <div class="Colacao flex flex-row justify-center w-[88vw] h-[46vh] gap-4 justify-self-center my-16">
      <div class="flex flex-col justify-center ">
        <img class="w-[42vw] h-[24vh] rounded-xl" src="https://picsum.photos/500/500" alt="">
        <img class="w-[36vw] h-[18vh] rounded-xl place-self-end mt-auto" src="https://picsum.photos/500/500" alt="">
      </div>
      <div class="flex flex-col justify-center">
        <img class="w-[28vw] h-[14vh] rounded-xl" src="https://picsum.photos/500/500" alt="">
        <img class="w-[40vw] h-[28vh] rounded-xl mt-auto " src="https://picsum.photos/500/500" alt="">
      </div>
    </div>
    <div class="mx-7">
      <P class="textoMobile text-CremeEscuro">Cada idoso do nosso lar traz consigo uma vida cheia de memórias, 
        aprendizados e momentos inesquecíveis.</P>
      <P class="textoMobile text-CremeEscuro">Aqui, cada rosto guarda uma história única. São pessoas que viveram,
         sonharam e ainda têm muito para compartilhar.</P>
      <P class="textoMobile text-CremeEscuro">Ao conhecê-los, você descobre não apenas histórias do passado, 
        mas também a alegria do presente e a esperança no futuro.</P>
    </div>
  </section>

  <script src="/Abrigo/assets/js/btn.js"></script>
</body>
</html>