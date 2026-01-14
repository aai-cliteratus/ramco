<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>AAI Worldwide Logistics</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<link rel="icon" type="image/png" href="{{ asset('img/favico.ico') }}">

<style>
/* Fade-in animations */
.fade-in { opacity:0; animation: fadeIn 1s forwards ease; }
@keyframes fadeIn {
  0% { opacity:0; transform: translateY(20px); }
  100% { opacity:1; transform: translateY(0); }
}

/* Feature cards */
.feature-card {
  background: rgba(0,255,255,0.05);
  border: 1px solid rgba(0,255,255,0.3);
  backdrop-filter: blur(10px);
  box-shadow:0 0 40px rgba(0,255,255,0.2);
}

/* Hover animation helpers */
.icon-wrapper {
  position: relative;
  height: 96px;
  overflow: visible;
}

.icon-up {
  transition: transform 0.6s cubic-bezier(.4,0,.2,1), opacity 0.4s;
}

.group:hover .icon-up,
.group:focus-within .icon-up {
  transform: translateY(-120px) scale(1.05);
  opacity: 0;
}

.icon-down {
  position: absolute;
  top: 0;
  left: 50%;
  transform: translate(-50%, -120px);
  opacity: 0;
  transition: transform 0.6s cubic-bezier(.4,0,.2,1),
              opacity 0.4s;
  filter: drop-shadow(0 0 12px rgba(0,255,255,0.6));
}

.group:hover .icon-down,
.group:focus-within .icon-down {
  transform: translate(-50%, 0);
  opacity: 1;
}

/* Logo Glow */
.logo-glow {
  filter: drop-shadow(0 0 6px #0ff)
          drop-shadow(0 0 12px #0ff)
          drop-shadow(0 0 24px #0ff);
  height: 80px;
}
</style>
</head>

<body class="bg-black text-cyan-100 overflow-hidden">

<div id="app" class="relative min-h-screen flex flex-col items-center justify-center p-6">

  <!-- Grid Background -->
  <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(34,211,238,0.05)_1px,transparent_1px),linear-gradient(to_bottom,rgba(34,211,238,0.05)_1px,transparent_1px)] bg-[length:40px_40px]"></div>

  <!-- Header -->
  <div class="relative max-w-6xl w-full text-center z-10">
    <div class="inline-flex items-center justify-center gap-4 mb-6 fade-in">
      <h1 class="text-5xl md:text-6xl font-extrabold tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-sky-400 to-indigo-400 flex items-center gap-4">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo-glow">
      </h1>
    </div>

    <p class="text-cyan-300 max-w-2xl mx-auto tracking-wide fade-in pt-4">
      AAI - Uploader Management
    </p>

    <!-- Feature Cards -->
    @verbatim
    <div class="flex justify-center flex-wrap gap-6 mt-16 z-10">
      <a v-for="(f, i) in features"
         :key="i"
         :href="f.link"
         class="feature-card group p-6 rounded-2xl
                hover:shadow-[0_0_60px_rgba(34,211,238,0.4)]
                transition fade-in block text-center">

<!-- ICON ANIMATION (SLOW DOWN DROP, NO REVERSE ON HOVER OUT) -->
<div class="relative mb-4 h-24 flex justify-center overflow-visible">

  <!-- UP ICON -->
  <img
    :src="f.icon"
    :alt="f.title"
    class="w-20 h-20 object-contain
           transition-none
           group-hover:transition-all group-hover:duration-300 group-hover:ease-out
           group-hover:-translate-y-20 group-hover:opacity-0"
  />

  <!-- DOWN ICON (SLOWER DROP) -->
  <img
    src="/img/inventory_download1.png"
    alt="Download"
    class="w-20 h-20 object-contain absolute
           opacity-0 translate-y-[-34px]
           transition-none
           group-hover:transition-all group-hover:duration-[1000ms] group-hover:ease-out
           group-hover:opacity-100 group-hover:translate-y-0"
    style="transition-delay: 0.35s"
  />

</div>




        <h3 class="text-xl font-semibold mb-2 text-cyan-200">{{ f.title }}</h3>
        <p class="text-cyan-300 text-sm">{{ f.desc }}</p>
      </a>
    </div>
    @endverbatim

  </div>
</div>

<script>
const { createApp, reactive, onMounted, ref } = Vue

createApp({
  setup() {
    const features = ref([
      {
        icon: '/img/inventory_download.png',
        title: 'Inventory Master With Serial',
        desc: 'Inventory With Serial Uploader',
        link: '/uploader/inventory_import'
      }
    ])

    return { features }
  }
}).mount('#app')
</script>

</body>
</html>
