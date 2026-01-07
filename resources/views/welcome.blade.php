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
@keyframes fadeIn { 0% { opacity:0; transform: translateY(20px); } 100% { opacity:1; transform: translateY(0); } }

/* Feature cards */
.feature-card {
  background: rgba(0,255,255,0.05);
  border: 1px solid rgba(0,255,255,0.3);
  backdrop-filter: blur(10px);
  box-shadow:0 0 40px rgba(0,255,255,0.2);
}

/* Neon glow for trucks and planes */
.neon-truck svg, .neon-plane svg {
  filter: drop-shadow(0 0 6px rgba(0,255,255,0.5)) drop-shadow(0 0 12px rgba(0,255,255,0.3));
}

/* Truck Trail */
.truck-trail {
  position: absolute;
  left: -60px;
  top: 8px;
  width: 60px;
  height: 16px;
  background: linear-gradient(to right, rgba(0,255,255,0.5), rgba(0,255,255,0));
  filter: blur(6px);
  border-radius: 8px;
}

/* Plane Trail */
.plane-trail {
  position: absolute;
  left: -60px;
  top: 4px;
  width: 60px;
  height: 12px;
  background: linear-gradient(to right, rgba(0,255,255,0.5), rgba(0,255,255,0));
  filter: blur(5px);
  border-radius: 6px;
  transform: rotate(-5deg);
}

/* Logo Glow */
.logo-glow {
  filter: drop-shadow(0 0 6px #0ff) drop-shadow(0 0 12px #0ff) drop-shadow(0 0 24px #0ff);
  height: 40px;
}
</style>
</head>
<body class="bg-black text-cyan-100 overflow-hidden">

<div id="app" class="relative min-h-screen flex flex-col items-center justify-center p-6">

  <!-- Grid Background -->
  <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(34,211,238,0.05)_1px,transparent_1px),linear-gradient(to_bottom,rgba(34,211,238,0.05)_1px,transparent_1px)] bg-[length:40px_40px]"></div>

  <!-- Trucks -->
  <div class="absolute bottom-0 w-full h-24">
    <div v-for="truck in trucks" :key="truck.id"
         class="absolute neon-truck"
         :style="{ left: truck.x + 'px', transform: 'scaleX(-1)' }">
      <div class="truck-trail"></div>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="64" height="32" fill="#0f2a50" stroke="#0ff" stroke-width="4">
        <path d="M0 96C0 60.7 28.7 32 64 32l288 0c35.3 0 64 28.7 64 64l0 32 50.7 0c17 0 33.3 6.7 45.3 18.7L557.3 192c12 12 18.7 28.3 18.7 45.3L576 384c0 35.3-28.7 64-64 64l-3.3 0c-10.4 36.9-44.4 64-84.7 64s-74.2-27.1-84.7-64l-102.6 0c-10.4 36.9-44.4 64-84.7 64s-74.2-27.1-84.7-64L64 448c-35.3 0-64-28.7-64-64L0 96zM512 288l0-50.7-45.3-45.3-50.7 0 0 96 96 0zM192 424a40 40 0 1 0 -80 0 40 40 0 1 0 80 0zm232 40a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"/>
      </svg>
    </div>
  </div>

  <!-- Planes -->
  <div class="absolute top-10 w-full h-16">
    <div v-for="plane in planes" :key="plane.id"
         class="absolute neon-plane"
         :style="{ left: plane.x + 'px' }">
      <div class="plane-trail"></div>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="48" height="32" fill="#0f2a50" stroke="#0ff" stroke-width="4">
        <path d="M520 200c30.9 0 56 25.1 56 56s-25.1 56-56 56l-127.3 0-159.2 173.6c-6.1 6.6-14.6 10.4-23.6 10.4l-43.7 0c-10.9 0-18.6-10.7-15.2-21.1l54.3-162.9-99.7 0-52.8 66c-3 3.8-7.6 6-12.5 6l-19.8 0c-10.4 0-18-9.8-15.5-19.9L32 256 5 147.9C2.4 137.8 10.1 128 20.5 128l19.8 0c4.9 0 9.5 2.2 12.5 6l52.8 66 99.7 0-54.3-162.9C147.6 26.7 155.3 16 166.2 16l43.7 0c9 0 17.5 3.8 23.6 10.4L392.7 200 520 200z"/>
      </svg>
    </div>
  </div>

  <!-- Header -->
  <div class="relative max-w-6xl w-full text-center z-10">
    <div class="inline-flex items-center justify-center gap-4 mb-6 fade-in">
      <h1 class="text-5xl md:text-6xl font-extrabold tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-sky-400 to-indigo-400 flex items-center gap-4">
        <img src="{{ asset('img/logo1.png') }}" alt="Logo" class="logo-glow">
        AAI WORLDWIDE LOGISTICS
      </h1>
    </div>
    <p class="text-cyan-300 max-w-2xl mx-auto tracking-wide fade-in">
      AAI - The Leading Independent Freight Forwarding and Logistics Service Provider in the Philippines 
    </p>

    <!-- Feature Cards -->
    @verbatim
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-16 z-10">
    <a v-for="(f, i) in features" 
        :key="i" 
        :href="f.link" 
        class="feature-card p-6 rounded-2xl hover:shadow-[0_0_60px_rgba(34,211,238,0.4)] transition fade-in block">
        <div class="mb-4 text-4xl">{{ f.icon }}</div>
        <h3 class="text-xl font-semibold mb-2 text-cyan-200">{{ f.title }}</h3>
        <p class="text-cyan-300 text-sm">{{ f.desc }}</p>
    </a>
    </div>
    @endverbatim

</div>

<script>
const { createApp, reactive, onMounted, ref } = Vue

createApp({
  setup() {
    const screenWidth = window.innerWidth

    // 3 trucks now
    const trucks = reactive([
      { id: 1, x: 0 },
      { id: 2, x: screenWidth / 3 },
      { id: 3, x: (2 * screenWidth) / 3 }
    ])

    // 3 planes now
    const planes = reactive([
      { id: 1, x: 0 },
      { id: 2, x: screenWidth / 3 },
      { id: 3, x: (2 * screenWidth) / 3 }
    ])

    const features = ref([
      { icon: '📊', title: 'Ramco', desc: 'Shows both inquiry and journal entry', link: '/ramco' },
      { icon: '🔍', title: 'Ramco Inquiry', desc: 'Shows inquiry only', link: '/ramco_inq' },
      { icon: '📝', title: 'Ramco Journal Entry', desc: 'Shows journal entry only', link: '/ramco_je' },
      { icon: '📝', title: 'Ramco Trial Balance', desc: 'Shows JE Trial Balance only', link: '/ramco_tb' },
    ])

    onMounted(() => {
      function animate() {
        trucks.forEach(t => { t.x -= 2; if (t.x < -80) t.x = screenWidth })
        planes.forEach(p => { p.x += 3; if (p.x > screenWidth) p.x = -60 })
        requestAnimationFrame(animate)
      }
      animate()
    })

    return { trucks, planes, features }
  }
}).mount('#app')
</script>
</body>
</html>
