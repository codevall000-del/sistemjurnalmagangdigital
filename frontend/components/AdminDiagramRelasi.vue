<template>
  <div class="h-full w-full flex flex-col overflow-hidden bg-[#f5f5f7] dark:bg-[#121214] select-none">
    <!-- 1. UNIFIED SINGLE TOP NAVBAR (macOS Frosted Glassmorphism Strip - Height 56px) -->
    <header class="h-14 px-5 bg-white/85 dark:bg-[#18181b]/90 backdrop-blur-2xl border-b border-black/[0.06] dark:border-white/[0.08] flex items-center justify-between shrink-0 z-30 shadow-[0_1px_4px_rgba(0,0,0,0.02)]">
      <!-- Left: Breadcrumb & Apple Segmented Control & Status -->
      <div class="flex items-center gap-3 shrink-0">
        <!-- Breadcrumb Navigation -->
        <div class="flex items-center gap-1.5 text-[#86868b] dark:text-[#98989f] text-[13px] font-medium mr-1">
          <span class="hover:text-[#1d1d1f] dark:hover:text-white transition-colors cursor-pointer" @click="activeMenu = 'dashboard_admin'">EduAccess</span>
          <span class="material-symbols-outlined text-[15px] opacity-60">chevron_right</span>
          <span class="text-[#1d1d1f] dark:text-[#f5f5f7] font-semibold">Diagram Relasi PKL</span>
        </div>

        <!-- Apple Segmented Mode Switcher -->
        <div class="inline-flex items-center p-0.5 bg-black/[0.05] dark:bg-white/[0.08] rounded-xl border border-black/[0.04] dark:border-white/[0.06] text-xs font-semibold">
          <button
            type="button"
            @click="switchDiagramMode('pipeline')"
            :class="activeDiagramMode === 'pipeline' ? 'bg-white dark:bg-[#2c2c2e] text-[#0071e3] shadow-xs' : 'text-[#86868b] hover:text-[#1d1d1f] dark:hover:text-white'"
            class="px-3 py-1 rounded-lg transition-all flex items-center gap-1.5 apple-press cursor-pointer whitespace-nowrap"
          >
            <span class="material-symbols-outlined text-[15px]">device_hub</span>
            <span>Alur Penempatan</span>
          </button>
          <button
            type="button"
            @click="switchDiagramMode('erd')"
            :class="activeDiagramMode === 'erd' ? 'bg-white dark:bg-[#2c2c2e] text-[#0071e3] shadow-xs' : 'text-[#86868b] hover:text-[#1d1d1f] dark:hover:text-white'"
            class="px-3 py-1 rounded-lg transition-all flex items-center gap-1.5 apple-press cursor-pointer whitespace-nowrap"
          >
            <span class="material-symbols-outlined text-[15px]">schema</span>
            <span>Skema ERD</span>
          </button>
        </div>

        <!-- Live Topology Status Capsule -->
        <div class="hidden lg:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#34c759]/10 text-[#248a3d] dark:text-[#34c759] border border-[#34c759]/20 text-[11px] font-semibold whitespace-nowrap">
          <span class="w-1.5 h-1.5 rounded-full bg-[#34c759] animate-pulse"></span>
          <span>{{ activeDiagramMode === 'pipeline' ? 'Topologi Terhubung (SMKN 71)' : '6 Entitas Database' }}</span>
        </div>
      </div>

      <!-- Center: Filter & Search (Cleanly Spaced) -->
      <div v-if="activeDiagramMode === 'pipeline'" class="hidden md:flex items-center gap-2.5 shrink-0">
        <!-- Filter Jurusan -->
        <div class="relative w-36">
          <select
            v-model="selectedMajorFilter"
            class="w-full appearance-none pl-3 pr-7 py-1.5 bg-black/[0.04] dark:bg-white/[0.06] hover:bg-black/[0.06] text-[#1d1d1f] dark:text-[#f5f5f7] border border-black/[0.06] dark:border-white/[0.08] rounded-xl text-xs font-semibold cursor-pointer transition focus:ring-2 focus:ring-[#0071e3]/30 truncate"
          >
            <option value="all">Semua Jurusan</option>
            <option value="PPLG">PPLG (Software)</option>
            <option value="Animasi">Animasi (3D)</option>
            <option value="DKV">DKV (Creative)</option>
          </select>
          <span class="material-symbols-outlined text-[16px] text-[#86868b] absolute right-2 top-2 pointer-events-none">expand_more</span>
        </div>

        <!-- Search Input -->
        <div class="relative w-52">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Cari guru, PT, siswa..."
            class="w-full pl-7 pr-6 py-1.5 bg-black/[0.04] dark:bg-white/[0.06] text-[#1d1d1f] dark:text-[#f5f5f7] border border-black/[0.06] dark:border-white/[0.08] rounded-xl text-xs placeholder-[#86868b] focus:ring-2 focus:ring-[#0071e3]/30 outline-none transition"
          />
          <span class="material-symbols-outlined text-[14px] text-[#86868b] absolute left-2 top-2">search</span>
          <button
            v-if="searchQuery"
            @click="searchQuery = ''"
            class="material-symbols-outlined text-[14px] text-[#86868b] hover:text-[#1d1d1f] absolute right-2 top-2 cursor-pointer"
          >
            close
          </button>
        </div>
      </div>

      <!-- Right: Expand Canvas, Action Button & Profile -->
      <div class="flex items-center gap-2.5 shrink-0">
        <!-- Perluas Kanvas (Expand / Zen Mode Toggle) -->
        <button
          type="button"
          @click="toggleSidebarCollapse"
          class="px-2.5 py-1.5 rounded-xl bg-black/[0.04] hover:bg-black/[0.08] dark:bg-white/[0.06] dark:hover:bg-white/[0.12] text-[#1d1d1f] dark:text-[#f5f5f7] border border-black/[0.06] dark:border-white/[0.08] text-xs font-semibold transition flex items-center gap-1.5 apple-press cursor-pointer"
          :title="isSidebarCollapsed ? 'Tampilkan Sidebar Navigasi' : 'Perluas Kanvas (Sembunyikan Sidebar)'"
        >
          <span class="material-symbols-outlined text-[16px]">{{ isSidebarCollapsed ? 'fullscreen_exit' : 'fullscreen' }}</span>
          <span class="hidden sm:inline text-[11px]">{{ isSidebarCollapsed ? 'Perkecil' : 'Perluas Kanvas' }}</span>
        </button>

        <!-- Kelola Plotting Button -->
        <button
          type="button"
          @click="activeMenu = 'plotting'"
          class="px-3.5 py-1.5 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-xs font-semibold shadow-xs transition flex items-center gap-1.5 apple-press cursor-pointer whitespace-nowrap"
          title="Buka Formulir Plotting Penempatan"
        >
          <span class="material-symbols-outlined text-[15px]">tune</span>
          <span>Kelola Plotting</span>
        </button>

        <!-- Apple User Profile Pill -->
        <div
          @click="openSettings('profile')"
          class="flex items-center gap-2 pl-2 border-l border-black/[0.08] dark:border-white/[0.08] cursor-pointer select-none group apple-press"
          title="Profil Administrator"
        >
          <img
            :src="currentUser.avatar || '/images/avatar-student.png'"
            alt="Profile"
            class="w-7 h-7 rounded-full object-cover border border-black/[0.08] shadow-xs"
          />
          <div class="hidden xl:flex flex-col text-left">
            <span class="text-[12px] text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight font-semibold group-hover:text-[#0071e3] transition-colors truncate max-w-[130px]">
              {{ currentUser.name }}
            </span>
            <span class="text-[10px] text-[#86868b] dark:text-[#98989f]">
              Admin Kaprog
            </span>
          </div>
          <span class="material-symbols-outlined text-[16px] text-[#86868b] group-hover:text-[#0071e3] transition-colors">
            arrow_drop_down
          </span>
        </div>
      </div>
    </header>

    <!-- 2. CANVAS WORKSPACE (Draw.io Infinite Pan & Zoom Stage) -->
    <div
      ref="canvasContainerRef"
      class="flex-1 relative overflow-hidden cursor-grab active:cursor-grabbing"
      @mousedown="startPan"
      @mousemove="handlePan"
      @mouseup="stopPan"
      @mouseleave="stopPan"
      @wheel.prevent="handleWheelZoom"
    >
      <!-- Draw.io Grid Background Styling -->
      <div
        class="absolute inset-0 pointer-events-none transition-opacity duration-300 opacity-60 dark:opacity-20"
        :style="{
          backgroundImage: 'radial-gradient(circle, #86868b 1px, transparent 1px)',
          backgroundSize: `${24 * zoomScale}px ${24 * zoomScale}px`,
          backgroundPosition: `${panX}px ${panY}px`
        }"
      ></div>

      <!-- TRANSFORMATION CONTAINER (PAN & ZOOM APPLIED) -->
      <div
        class="absolute origin-top-left transition-transform duration-75 ease-out select-none"
        :style="{
          transform: `translate(${panX}px, ${panY}px) scale(${zoomScale})`,
          width: activeDiagramMode === 'pipeline' ? '1280px' : '1340px',
          height: activeDiagramMode === 'pipeline' ? '650px' : '700px'
        }"
      >
        <!-- ======================================================== -->
        <!-- MODE A: PETA ALUR PENEMPATAN (FLOWCHART PIPELINE DRAW.IO) -->
        <!-- ======================================================== -->
        <div v-if="activeDiagramMode === 'pipeline'" class="relative w-full h-full p-6 pt-4">
          <!-- 4 Stage Column Header Pills (Clean & Perfectly Aligned Above Cards) -->
          <div class="relative w-full h-10 mb-4">
            <!-- Stage 1: Guru (x=40, w=240) -->
            <div class="absolute left-[40px] w-[240px] flex items-center justify-between px-3 py-1.5 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 shadow-xs">
              <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">school</span>
                <span class="text-[11px] font-bold uppercase tracking-wider">1. Guru Pembimbing</span>
              </div>
              <span class="text-[9px] font-mono px-1.5 py-0.2 rounded bg-emerald-500/20 font-bold">Sekolah</span>
            </div>

            <!-- Stage 2: Mitra PKL (x=360, w=250) -->
            <div class="absolute left-[360px] w-[250px] flex items-center justify-between px-3 py-1.5 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20 shadow-xs">
              <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">domain</span>
                <span class="text-[11px] font-bold uppercase tracking-wider">2. Mitra Tempat PKL</span>
              </div>
              <span class="text-[9px] font-mono px-1.5 py-0.2 rounded bg-blue-500/20 font-bold">Industri</span>
            </div>

            <!-- Stage 3: Pembimbing DUDI (x=690, w=240) -->
            <div class="absolute left-[690px] w-[240px] flex items-center justify-between px-3 py-1.5 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 shadow-xs">
              <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">supervisor_account</span>
                <span class="text-[11px] font-bold uppercase tracking-wider">3. Pembimbing DUDI</span>
              </div>
              <span class="text-[9px] font-mono px-1.5 py-0.2 rounded bg-indigo-500/20 font-bold">Mentor</span>
            </div>

            <!-- Stage 4: Siswa Binaan (x=1010, w=220) -->
            <div class="absolute left-[1010px] w-[220px] flex items-center justify-between px-3 py-1.5 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 shadow-xs">
              <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">badge</span>
                <span class="text-[11px] font-bold uppercase tracking-wider">4. Siswa Binaan</span>
              </div>
              <span class="text-[9px] font-mono px-1.5 py-0.2 rounded bg-amber-500/20 font-bold">Peserta</span>
            </div>
          </div>

          <!-- SVG CONNECTORS LAYER (Draw.io Smart Smooth Bezier Curves) -->
          <svg class="absolute inset-0 w-full h-full pointer-events-none z-10">
            <defs>
              <marker id="arrow-default" viewBox="0 0 10 10" refX="7" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
                <path d="M 0 1.5 L 8 5 L 0 8.5 z" fill="#86868b" opacity="0.6" />
              </marker>
              <marker id="arrow-pplg" viewBox="0 0 10 10" refX="7" refY="5" markerWidth="6.5" markerHeight="6.5" orient="auto-start-reverse">
                <path d="M 0 1.5 L 8 5 L 0 8.5 z" fill="#0071e3" />
              </marker>
              <marker id="arrow-animasi" viewBox="0 0 10 10" refX="7" refY="5" markerWidth="6.5" markerHeight="6.5" orient="auto-start-reverse">
                <path d="M 0 1.5 L 8 5 L 0 8.5 z" fill="#a855f7" />
              </marker>
              <marker id="arrow-dkv" viewBox="0 0 10 10" refX="7" refY="5" markerWidth="6.5" markerHeight="6.5" orient="auto-start-reverse">
                <path d="M 0 1.5 L 8 5 L 0 8.5 z" fill="#f59e0b" />
              </marker>
              <filter id="glow-line" x="-20%" y="-20%" width="140%" height="140%">
                <feGaussianBlur stdDeviation="3.5" result="blur" />
                <feComposite in="SourceGraphic" in2="blur" operator="over" />
              </filter>
            </defs>

            <!-- Draw Clean, Flowing Connector Paths -->
            <g v-for="edge in visiblePipelineEdges" :key="edge.id">
              <!-- Glow shadow when active -->
              <path
                v-if="edge.isActive"
                :d="edge.d"
                fill="none"
                :stroke="edge.color"
                stroke-width="5"
                stroke-opacity="0.3"
                filter="url(#glow-line)"
              />
              <!-- Main connector path -->
              <path
                :d="edge.d"
                fill="none"
                :stroke="edge.isActive ? edge.color : '#86868b'"
                :stroke-width="edge.isActive ? 2.5 : 1.5"
                :stroke-opacity="edge.isActive ? 1 : 0.25"
                :stroke-dasharray="edge.isActive && isPulseAnimationActive ? '6,4' : 'none'"
                :class="{ 'animate-flow-dash': edge.isActive && isPulseAnimationActive }"
                :marker-end="edge.isActive ? `url(#${edge.markerId})` : 'url(#arrow-default)'"
              />
            </g>
          </svg>

          <!-- ABSOLUTE CLEAN NODES CANVAS (Structured Horizontal Parallel Rows) -->
          <div class="relative w-full h-full z-20">
            <!-- ===================== COLUMN 1: GURU PEMBIMBING (x=40, w=240) ===================== -->
            <!-- Guru 1: Dra. Nurul Hidayah -->
            <div
              @click.stop="selectNode('guru', 2)"
              :class="getNodeClasses('guru', 2)"
              class="node-card absolute left-[40px] top-[100px] w-[240px] p-4 rounded-2xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <!-- Port Out (Right) -->
              <div class="absolute -right-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-emerald-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>

              <div class="flex items-center gap-3">
                <img :src="guruList[0].avatar" class="w-11 h-11 rounded-xl object-cover shrink-0 border border-black/[0.08]" />
                <div class="flex-1 min-w-0">
                  <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-600 block w-fit mb-0.5">
                    Pembimbing Utama
                  </span>
                  <h3 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight group-hover:text-[#0071e3] transition-colors">
                    {{ guruList[0].name }}
                  </h3>
                  <p class="text-[10px] text-[#86868b] font-mono mt-0.5">NIP: {{ guruList[0].nip }}</p>
                </div>
              </div>
              <div class="mt-3 pt-2 border-t border-black/[0.05] dark:border-white/[0.06] flex items-center justify-between text-[10.5px]">
                <span class="text-[#86868b]">Binaan:</span>
                <span class="font-bold text-emerald-600 dark:text-emerald-400 font-mono">3 Industri • 6 Siswa</span>
              </div>
            </div>

            <!-- Guru 2: Bambang Irawan -->
            <div
              @click.stop="selectNode('guru', 12)"
              :class="getNodeClasses('guru', 12)"
              class="node-card absolute left-[40px] top-[360px] w-[240px] p-4 rounded-2xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -right-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-emerald-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>

              <div class="flex items-center gap-3">
                <img :src="guruList[1].avatar" class="w-11 h-11 rounded-xl object-cover shrink-0 border border-black/[0.08]" />
                <div class="flex-1 min-w-0">
                  <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-600 block w-fit mb-0.5">
                    Koordinator PPLG
                  </span>
                  <h3 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight group-hover:text-[#0071e3] transition-colors">
                    {{ guruList[1].name }}
                  </h3>
                  <p class="text-[10px] text-[#86868b] font-mono mt-0.5">NIP: {{ guruList[1].nip }}</p>
                </div>
              </div>
              <div class="mt-3 pt-2 border-t border-black/[0.05] dark:border-white/[0.06] flex items-center justify-between text-[10.5px]">
                <span class="text-[#86868b]">Pendamping:</span>
                <span class="font-bold text-emerald-600 dark:text-emerald-400 font-mono">PT Telkom Solusi</span>
              </div>
            </div>

            <!-- ===================== COLUMN 2: MITRA TEMPAT PKL (x=360, w=250) ===================== -->
            <!-- PT Telkom Digital Solusi (Row 1) -->
            <div
              @click.stop="selectNode('company', 1)"
              :class="getNodeClasses('company', 1)"
              class="node-card absolute left-[360px] top-[60px] w-[250px] p-4 rounded-2xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-blue-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>
              <div class="absolute -right-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-blue-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>

              <div class="flex items-start gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg shrink-0">
                  💻
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between gap-1 mb-0.5">
                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-blue-500/10 text-blue-600">PPLG</span>
                    <span class="text-[9px] font-mono text-[#86868b]">WFO &amp; WFH</span>
                  </div>
                  <h3 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight group-hover:text-[#0071e3] transition-colors truncate">
                    PT Telkom Digital Solusi
                  </h3>
                  <p class="text-[10px] text-[#86868b] mt-0.5 truncate">Software House &amp; Cloud</p>
                </div>
              </div>
              <div class="mt-2.5 pt-2 border-t border-black/[0.05] dark:border-white/[0.06] flex items-center justify-between text-[10.5px]">
                <span class="text-[#86868b]">Kapasitas:</span>
                <span class="font-bold text-[#0071e3] font-mono">2 / 6 Kursi Terisi</span>
              </div>
            </div>

            <!-- Studio Animasi Kinetik Digital (Row 2) -->
            <div
              @click.stop="selectNode('company', 2)"
              :class="getNodeClasses('company', 2)"
              class="node-card absolute left-[360px] top-[250px] w-[250px] p-4 rounded-2xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-purple-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>
              <div class="absolute -right-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-purple-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>

              <div class="flex items-start gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg shrink-0">
                  🎬
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between gap-1 mb-0.5">
                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-purple-500/10 text-purple-600">Animasi</span>
                    <span class="text-[9px] font-mono text-[#86868b]">Hybrid</span>
                  </div>
                  <h3 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight group-hover:text-[#0071e3] transition-colors truncate">
                    Studio Animasi Kinetik
                  </h3>
                  <p class="text-[10px] text-[#86868b] mt-0.5 truncate">3D Animation &amp; CGI Studio</p>
                </div>
              </div>
              <div class="mt-2.5 pt-2 border-t border-black/[0.05] dark:border-white/[0.06] flex items-center justify-between text-[10.5px]">
                <span class="text-[#86868b]">Kapasitas:</span>
                <span class="font-bold text-purple-600 font-mono">2 / 4 Kursi Terisi</span>
              </div>
            </div>

            <!-- Pixel Kreatif Visual Agency (Row 3) -->
            <div
              @click.stop="selectNode('company', 3)"
              :class="getNodeClasses('company', 3)"
              class="node-card absolute left-[360px] top-[440px] w-[250px] p-4 rounded-2xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-amber-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>
              <div class="absolute -right-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-amber-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>

              <div class="flex items-start gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg shrink-0">
                  🎨
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between gap-1 mb-0.5">
                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-amber-500/10 text-amber-600">DKV</span>
                    <span class="text-[9px] font-mono text-[#86868b]">WFO &amp; WFA</span>
                  </div>
                  <h3 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight group-hover:text-[#0071e3] transition-colors truncate">
                    Pixel Kreatif Visual
                  </h3>
                  <p class="text-[10px] text-[#86868b] mt-0.5 truncate">Brand Identity &amp; UI/UX</p>
                </div>
              </div>
              <div class="mt-2.5 pt-2 border-t border-black/[0.05] dark:border-white/[0.06] flex items-center justify-between text-[10.5px]">
                <span class="text-[#86868b]">Kapasitas:</span>
                <span class="font-bold text-amber-600 font-mono">2 / 5 Kursi Terisi</span>
              </div>
            </div>

            <!-- ===================== COLUMN 3: PEMBIMBING LAPANGAN (x=690, w=240) ===================== -->
            <!-- Mentor 1: Hendra Wijaya (Row 1) -->
            <div
              @click.stop="selectNode('mentor', 3)"
              :class="getNodeClasses('mentor', 3)"
              class="node-card absolute left-[690px] top-[60px] w-[240px] p-4 rounded-2xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-indigo-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>
              <div class="absolute -right-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-indigo-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>

              <div class="flex items-center gap-2.5">
                <img :src="mentorList[0].avatar" class="w-10 h-10 rounded-xl object-cover shrink-0 border border-black/[0.08]" />
                <div class="flex-1 min-w-0">
                  <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-600 block w-fit mb-0.5">
                    Mentor DUDI
                  </span>
                  <h3 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight group-hover:text-[#0071e3] transition-colors truncate">
                    {{ mentorList[0].name }}
                  </h3>
                  <p class="text-[10px] text-[#86868b] mt-0.5 truncate">{{ mentorList[0].division }}</p>
                </div>
              </div>
              <div class="mt-2.5 pt-2 border-t border-black/[0.05] dark:border-white/[0.06] flex items-center justify-between text-[10.5px]">
                <span class="text-[#86868b]">Bimbingan:</span>
                <span class="font-bold text-indigo-600 dark:text-indigo-400 font-mono">2 Siswa Aktif</span>
              </div>
            </div>

            <!-- Mentor 2: Raditya Pratama (Row 2) -->
            <div
              @click.stop="selectNode('mentor', 10)"
              :class="getNodeClasses('mentor', 10)"
              class="node-card absolute left-[690px] top-[250px] w-[240px] p-4 rounded-2xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-indigo-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>
              <div class="absolute -right-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-indigo-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>

              <div class="flex items-center gap-2.5">
                <img :src="mentorList[1].avatar" class="w-10 h-10 rounded-xl object-cover shrink-0 border border-black/[0.08]" />
                <div class="flex-1 min-w-0">
                  <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-600 block w-fit mb-0.5">
                    Mentor DUDI
                  </span>
                  <h3 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight group-hover:text-[#0071e3] transition-colors truncate">
                    {{ mentorList[1].name }}
                  </h3>
                  <p class="text-[10px] text-[#86868b] mt-0.5 truncate">{{ mentorList[1].division }}</p>
                </div>
              </div>
              <div class="mt-2.5 pt-2 border-t border-black/[0.05] dark:border-white/[0.06] flex items-center justify-between text-[10.5px]">
                <span class="text-[#86868b]">Bimbingan:</span>
                <span class="font-bold text-indigo-600 dark:text-indigo-400 font-mono">2 Siswa Aktif</span>
              </div>
            </div>

            <!-- Mentor 3: Maya Safitri (Row 3) -->
            <div
              @click.stop="selectNode('mentor', 11)"
              :class="getNodeClasses('mentor', 11)"
              class="node-card absolute left-[690px] top-[440px] w-[240px] p-4 rounded-2xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-indigo-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>
              <div class="absolute -right-1.5 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-indigo-500 border-2 border-white dark:border-[#1e1e22] shadow-sm"></div>

              <div class="flex items-center gap-2.5">
                <img :src="mentorList[2].avatar" class="w-10 h-10 rounded-xl object-cover shrink-0 border border-black/[0.08]" />
                <div class="flex-1 min-w-0">
                  <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-600 block w-fit mb-0.5">
                    Mentor DUDI
                  </span>
                  <h3 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight group-hover:text-[#0071e3] transition-colors truncate">
                    {{ mentorList[2].name }}
                  </h3>
                  <p class="text-[10px] text-[#86868b] mt-0.5 truncate">{{ mentorList[2].division }}</p>
                </div>
              </div>
              <div class="mt-2.5 pt-2 border-t border-black/[0.05] dark:border-white/[0.06] flex items-center justify-between text-[10.5px]">
                <span class="text-[#86868b]">Bimbingan:</span>
                <span class="font-bold text-indigo-600 dark:text-indigo-400 font-mono">2 Siswa Aktif</span>
              </div>
            </div>

            <!-- ===================== COLUMN 4: SISWA PESERTA PKL (x=1010, w=220) ===================== -->
            <!-- Siswa 1: Budi Santoso (Row 1a) -->
            <div
              @click.stop="selectNode('siswa', 4)"
              :class="getNodeClasses('siswa', 4)"
              class="node-card absolute left-[1010px] top-[60px] w-[220px] p-2.5 rounded-xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-2.5 h-2.5 rounded-full bg-blue-500 border-2 border-white dark:border-[#1e1e22]"></div>
              <div class="flex items-center gap-2.5">
                <img :src="studentList[0].avatar" class="w-8 h-8 rounded-lg object-cover shrink-0 border border-black/[0.08]" />
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight truncate group-hover:text-[#0071e3] transition-colors">{{ studentList[0].name }}</h4>
                    <span class="text-[8.5px] font-mono px-1 py-0.2 rounded bg-emerald-500/10 text-emerald-600 font-bold">WFO</span>
                  </div>
                  <p class="text-[9.5px] text-[#86868b] font-mono mt-0.5 truncate">{{ studentList[0].className }} • {{ studentList[0].nisn }}</p>
                </div>
              </div>
            </div>

            <!-- Siswa 2: Siti Fauziah (Row 1b) -->
            <div
              @click.stop="selectNode('siswa', 5)"
              :class="getNodeClasses('siswa', 5)"
              class="node-card absolute left-[1010px] top-[138px] w-[220px] p-2.5 rounded-xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-2.5 h-2.5 rounded-full bg-blue-500 border-2 border-white dark:border-[#1e1e22]"></div>
              <div class="flex items-center gap-2.5">
                <img :src="studentList[1].avatar" class="w-8 h-8 rounded-lg object-cover shrink-0 border border-black/[0.08]" />
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight truncate group-hover:text-[#0071e3] transition-colors">{{ studentList[1].name }}</h4>
                    <span class="text-[8.5px] font-mono px-1 py-0.2 rounded bg-blue-500/10 text-blue-600 font-bold">WFH</span>
                  </div>
                  <p class="text-[9.5px] text-[#86868b] font-mono mt-0.5 truncate">{{ studentList[1].className }} • {{ studentList[1].nisn }}</p>
                </div>
              </div>
            </div>

            <!-- Siswa 3: Ahmad Danu (Row 2a) -->
            <div
              @click.stop="selectNode('siswa', 6)"
              :class="getNodeClasses('siswa', 6)"
              class="node-card absolute left-[1010px] top-[250px] w-[220px] p-2.5 rounded-xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-2.5 h-2.5 rounded-full bg-purple-500 border-2 border-white dark:border-[#1e1e22]"></div>
              <div class="flex items-center gap-2.5">
                <img :src="studentList[2].avatar" class="w-8 h-8 rounded-lg object-cover shrink-0 border border-black/[0.08]" />
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight truncate group-hover:text-[#0071e3] transition-colors">{{ studentList[2].name }}</h4>
                    <span class="text-[8.5px] font-mono px-1 py-0.2 rounded bg-purple-500/10 text-purple-600 font-bold">WFA</span>
                  </div>
                  <p class="text-[9.5px] text-[#86868b] font-mono mt-0.5 truncate">{{ studentList[2].className }} • {{ studentList[2].nisn }}</p>
                </div>
              </div>
            </div>

            <!-- Siswa 4: Putri Maharani (Row 2b) -->
            <div
              @click.stop="selectNode('siswa', 7)"
              :class="getNodeClasses('siswa', 7)"
              class="node-card absolute left-[1010px] top-[328px] w-[220px] p-2.5 rounded-xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-2.5 h-2.5 rounded-full bg-purple-500 border-2 border-white dark:border-[#1e1e22]"></div>
              <div class="flex items-center gap-2.5">
                <img :src="studentList[3].avatar" class="w-8 h-8 rounded-lg object-cover shrink-0 border border-black/[0.08]" />
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight truncate group-hover:text-[#0071e3] transition-colors">{{ studentList[3].name }}</h4>
                    <span class="text-[8.5px] font-mono px-1 py-0.2 rounded bg-emerald-500/10 text-emerald-600 font-bold">WFO</span>
                  </div>
                  <p class="text-[9.5px] text-[#86868b] font-mono mt-0.5 truncate">{{ studentList[3].className }} • {{ studentList[3].nisn }}</p>
                </div>
              </div>
            </div>

            <!-- Siswa 5: Rizky Pratama (Row 3a) -->
            <div
              @click.stop="selectNode('siswa', 8)"
              :class="getNodeClasses('siswa', 8)"
              class="node-card absolute left-[1010px] top-[440px] w-[220px] p-2.5 rounded-xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-2.5 h-2.5 rounded-full bg-amber-500 border-2 border-white dark:border-[#1e1e22]"></div>
              <div class="flex items-center gap-2.5">
                <img :src="studentList[4].avatar" class="w-8 h-8 rounded-lg object-cover shrink-0 border border-black/[0.08]" />
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight truncate group-hover:text-[#0071e3] transition-colors">{{ studentList[4].name }}</h4>
                    <span class="text-[8.5px] font-mono px-1 py-0.2 rounded bg-emerald-500/10 text-emerald-600 font-bold">WFO</span>
                  </div>
                  <p class="text-[9.5px] text-[#86868b] font-mono mt-0.5 truncate">{{ studentList[4].className }} • {{ studentList[4].nisn }}</p>
                </div>
              </div>
            </div>

            <!-- Siswa 6: Jessica Tan (Row 3b) -->
            <div
              @click.stop="selectNode('siswa', 9)"
              :class="getNodeClasses('siswa', 9)"
              class="node-card absolute left-[1010px] top-[518px] w-[220px] p-2.5 rounded-xl bg-white dark:bg-[#1e1e22] border transition-all duration-200 cursor-pointer shadow-sm group"
            >
              <div class="absolute -left-1.5 top-1/2 -translate-y-1/2 w-2.5 h-2.5 rounded-full bg-amber-500 border-2 border-white dark:border-[#1e1e22]"></div>
              <div class="flex items-center gap-2.5">
                <img :src="studentList[5].avatar" class="w-8 h-8 rounded-lg object-cover shrink-0 border border-black/[0.08]" />
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight truncate group-hover:text-[#0071e3] transition-colors">{{ studentList[5].name }}</h4>
                    <span class="text-[8.5px] font-mono px-1 py-0.2 rounded bg-blue-500/10 text-blue-600 font-bold">WFH</span>
                  </div>
                  <p class="text-[9.5px] text-[#86868b] font-mono mt-0.5 truncate">{{ studentList[5].className }} • {{ studentList[5].nisn }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ======================================================== -->
        <!-- MODE B: SKEMA DATABASE RELASIONAL (ERD DRAW.IO VIEW)     -->
        <!-- ======================================================== -->
        <div v-else class="relative w-full h-full p-6 pt-4">
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-500/20 shadow-xs">
              <span class="material-symbols-outlined text-[17px]">database</span>
              <span class="text-xs font-bold uppercase tracking-wider">Skema Basis Data Relasional EduAccess (SQLite / MariaDB)</span>
            </div>
            <span class="text-xs text-[#86868b] font-mono">6 Entitas Tabel Inti • Foreign Key Relational Architecture</span>
          </div>

          <!-- ERD SVG CONNECTORS -->
          <svg class="absolute inset-0 w-full h-full pointer-events-none z-10">
            <defs>
              <marker id="erd-arrow" viewBox="0 0 10 10" refX="7" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
                <path d="M 0 1.5 L 8 5 L 0 8.5 z" fill="#0071e3" />
              </marker>
            </defs>
            <path d="M 370 140 C 440 140, 440 220, 500 220" fill="none" stroke="#0071e3" stroke-width="2" stroke-dasharray="5,4" marker-end="url(#erd-arrow)" />
            <path d="M 370 410 C 440 410, 440 270, 500 270" fill="none" stroke="#34c759" stroke-width="2" stroke-dasharray="5,4" marker-end="url(#erd-arrow)" />
            <path d="M 760 240 C 830 240, 850 140, 920 140" fill="none" stroke="#f59e0b" stroke-width="2" stroke-dasharray="5,4" marker-end="url(#erd-arrow)" />
            <path d="M 760 280 C 830 280, 850 400, 920 400" fill="none" stroke="#ec4899" stroke-width="2" stroke-dasharray="5,4" marker-end="url(#erd-arrow)" />
            <path d="M 370 180 C 450 180, 840 550, 920 550" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-dasharray="5,4" marker-end="url(#erd-arrow)" />
          </svg>

          <!-- ERD TABLES GRID (Structured 2-row layout) -->
          <div class="relative w-full h-full z-20">
            <!-- Table 1: USERS (x=60, y=40, w=310) -->
            <div
              @click.stop="selectErdTable('users')"
              :class="selectedErdTable === 'users' ? 'ring-3 ring-[#0071e3]/40 border-[#0071e3] shadow-lg' : 'hover:border-[#0071e3]/40'"
              class="absolute left-[60px] top-[40px] w-[310px] bg-white dark:bg-[#1e1e22] rounded-2xl border border-black/[0.08] dark:border-white/[0.08] shadow-sm overflow-hidden transition-all cursor-pointer"
            >
              <div class="bg-blue-600 text-white px-3.5 py-2 flex items-center justify-between">
                <span class="font-mono font-bold text-xs flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px]">table_chart</span>users</span>
                <span class="text-[9px] bg-white/20 px-1.5 py-0.2 rounded font-mono">Master</span>
              </div>
              <div class="p-3 font-mono text-[10.5px] divide-y divide-black/[0.04] dark:divide-white/[0.04]">
                <div class="py-1 flex justify-between text-[#0071e3] font-bold"><span>🔑 id</span><span class="text-[#86868b]">BIGINT (PK)</span></div>
                <div class="py-1 flex justify-between"><span>name</span><span class="text-[#86868b]">VARCHAR</span></div>
                <div class="py-1 flex justify-between"><span>email</span><span class="text-[#86868b]">VARCHAR UNIQUE</span></div>
                <div class="py-1 flex justify-between"><span>role</span><span class="text-[#86868b]">ENUM</span></div>
                <div class="py-1 flex justify-between"><span>nisn_nip</span><span class="text-[#86868b]">VARCHAR</span></div>
              </div>
            </div>

            <!-- Table 2: PLACEMENTS (x=500, y=150, w=260) -->
            <div
              @click.stop="selectErdTable('placements')"
              :class="selectedErdTable === 'placements' ? 'ring-3 ring-[#0071e3]/40 border-[#0071e3] shadow-lg' : 'hover:border-[#0071e3]/40'"
              class="absolute left-[500px] top-[150px] w-[260px] bg-white dark:bg-[#1e1e22] rounded-2xl border border-black/[0.08] dark:border-white/[0.08] shadow-sm overflow-hidden transition-all cursor-pointer"
            >
              <div class="bg-indigo-600 text-white px-3.5 py-2 flex items-center justify-between">
                <span class="font-mono font-bold text-xs flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px]">hub</span>placements</span>
                <span class="text-[9px] bg-white/20 px-1.5 py-0.2 rounded font-mono">Pivot Matching</span>
              </div>
              <div class="p-3 font-mono text-[10.5px] divide-y divide-black/[0.04] dark:divide-white/[0.04]">
                <div class="py-1 flex justify-between text-[#0071e3] font-bold"><span>🔑 id</span><span class="text-[#86868b]">BIGINT (PK)</span></div>
                <div class="py-1 flex justify-between text-indigo-600 font-semibold"><span>🔗 student_id</span><span class="text-[#86868b]">FK ➔ users</span></div>
                <div class="py-1 flex justify-between text-indigo-600 font-semibold"><span>🔗 company_id</span><span class="text-[#86868b]">FK ➔ companies</span></div>
                <div class="py-1 flex justify-between text-indigo-600 font-semibold"><span>🔗 mentor_id</span><span class="text-[#86868b]">FK ➔ users</span></div>
                <div class="py-1 flex justify-between text-indigo-600 font-semibold"><span>🔗 teacher_id</span><span class="text-[#86868b]">FK ➔ users</span></div>
              </div>
            </div>

            <!-- Table 3: LOGBOOKS (x=920, y=40, w=270) -->
            <div
              @click.stop="selectErdTable('logbooks')"
              :class="selectedErdTable === 'logbooks' ? 'ring-3 ring-[#0071e3]/40 border-[#0071e3] shadow-lg' : 'hover:border-[#0071e3]/40'"
              class="absolute left-[920px] top-[40px] w-[270px] bg-white dark:bg-[#1e1e22] rounded-2xl border border-black/[0.08] dark:border-white/[0.08] shadow-sm overflow-hidden transition-all cursor-pointer"
            >
              <div class="bg-amber-600 text-white px-3.5 py-2 flex items-center justify-between">
                <span class="font-mono font-bold text-xs flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px]">edit_note</span>logbooks</span>
                <span class="text-[9px] bg-white/20 px-1.5 py-0.2 rounded font-mono">STAR Format</span>
              </div>
              <div class="p-3 font-mono text-[10.5px] divide-y divide-black/[0.04] dark:divide-white/[0.04]">
                <div class="py-1 flex justify-between text-[#0071e3] font-bold"><span>🔑 id</span><span class="text-[#86868b]">BIGINT (PK)</span></div>
                <div class="py-1 flex justify-between text-amber-600 font-semibold"><span>🔗 student_id</span><span class="text-[#86868b]">FK ➔ users</span></div>
                <div class="py-1 flex justify-between"><span>situation, task</span><span class="text-[#86868b]">TEXT</span></div>
                <div class="py-1 flex justify-between"><span>action, result</span><span class="text-[#86868b]">TEXT</span></div>
              </div>
            </div>

            <!-- Table 4: COMPANIES (x=60, y=330, w=310) -->
            <div
              @click.stop="selectErdTable('companies')"
              :class="selectedErdTable === 'companies' ? 'ring-3 ring-[#0071e3]/40 border-[#0071e3] shadow-lg' : 'hover:border-[#0071e3]/40'"
              class="absolute left-[60px] top-[330px] w-[310px] bg-white dark:bg-[#1e1e22] rounded-2xl border border-black/[0.08] dark:border-white/[0.08] shadow-sm overflow-hidden transition-all cursor-pointer"
            >
              <div class="bg-emerald-600 text-white px-3.5 py-2 flex items-center justify-between">
                <span class="font-mono font-bold text-xs flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px]">domain</span>companies</span>
                <span class="text-[9px] bg-white/20 px-1.5 py-0.2 rounded font-mono">Mitra DUDI</span>
              </div>
              <div class="p-3 font-mono text-[10.5px] divide-y divide-black/[0.04] dark:divide-white/[0.04]">
                <div class="py-1 flex justify-between text-[#0071e3] font-bold"><span>🔑 id</span><span class="text-[#86868b]">BIGINT (PK)</span></div>
                <div class="py-1 flex justify-between"><span>name</span><span class="text-[#86868b]">VARCHAR</span></div>
                <div class="py-1 flex justify-between"><span>quota</span><span class="text-[#86868b]">INT</span></div>
                <div class="py-1 flex justify-between"><span>radius_meters</span><span class="text-[#86868b]">INT</span></div>
              </div>
            </div>

            <!-- Table 5: ATTENDANCES (x=920, y=280, w=270) -->
            <div
              @click.stop="selectErdTable('attendances')"
              :class="selectedErdTable === 'attendances' ? 'ring-3 ring-[#0071e3]/40 border-[#0071e3] shadow-lg' : 'hover:border-[#0071e3]/40'"
              class="absolute left-[920px] top-[280px] w-[270px] bg-white dark:bg-[#1e1e22] rounded-2xl border border-black/[0.08] dark:border-white/[0.08] shadow-sm overflow-hidden transition-all cursor-pointer"
            >
              <div class="bg-pink-600 text-white px-3.5 py-2 flex items-center justify-between">
                <span class="font-mono font-bold text-xs flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px]">pin_drop</span>attendances</span>
                <span class="text-[9px] bg-white/20 px-1.5 py-0.2 rounded font-mono">GPS</span>
              </div>
              <div class="p-3 font-mono text-[10.5px] divide-y divide-black/[0.04] dark:divide-white/[0.04]">
                <div class="py-1 flex justify-between text-[#0071e3] font-bold"><span>🔑 id</span><span class="text-[#86868b]">BIGINT (PK)</span></div>
                <div class="py-1 flex justify-between text-pink-600 font-semibold"><span>🔗 student_id</span><span class="text-[#86868b]">FK ➔ users</span></div>
                <div class="py-1 flex justify-between"><span>check_in, out</span><span class="text-[#86868b]">TIME</span></div>
                <div class="py-1 flex justify-between"><span>work_mode</span><span class="text-[#86868b]">ENUM</span></div>
              </div>
            </div>

            <!-- Table 6: GRADES (x=920, y=470, w=270) -->
            <div
              @click.stop="selectErdTable('grades')"
              :class="selectedErdTable === 'grades' ? 'ring-3 ring-[#0071e3]/40 border-[#0071e3] shadow-lg' : 'hover:border-[#0071e3]/40'"
              class="absolute left-[920px] top-[470px] w-[270px] bg-white dark:bg-[#1e1e22] rounded-2xl border border-black/[0.08] dark:border-white/[0.08] shadow-sm overflow-hidden transition-all cursor-pointer"
            >
              <div class="bg-purple-600 text-white px-3.5 py-2 flex items-center justify-between">
                <span class="font-mono font-bold text-xs flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px]">workspace_premium</span>grades</span>
                <span class="text-[9px] bg-white/20 px-1.5 py-0.2 rounded font-mono">Nilai &amp; QR</span>
              </div>
              <div class="p-3 font-mono text-[10.5px] divide-y divide-black/[0.04] dark:divide-white/[0.04]">
                <div class="py-1 flex justify-between text-[#0071e3] font-bold"><span>🔑 id</span><span class="text-[#86868b]">BIGINT (PK)</span></div>
                <div class="py-1 flex justify-between text-purple-600 font-semibold"><span>🔗 student_id</span><span class="text-[#86868b]">FK ➔ users</span></div>
                <div class="py-1 flex justify-between"><span>final_score</span><span class="text-[#86868b]">DECIMAL</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 3. FLOATING DETAIL INSPECTOR PANEL (Draw.io Properties Sheet) -->
      <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="translate-x-full opacity-0"
        enter-to-class="translate-x-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="translate-x-0 opacity-100"
        leave-to-class="translate-x-full opacity-0"
      >
        <div
          v-if="selectedNodeData"
          class="absolute right-5 top-5 bottom-5 w-88 bg-white/95 dark:bg-[#1c1c1f]/95 backdrop-blur-2xl border border-black/[0.08] dark:border-white/[0.1] rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] flex flex-col z-40 overflow-hidden"
          @mousedown.stop
        >
          <!-- Header Card -->
          <div class="p-4 pb-3 border-b border-black/[0.06] dark:border-white/[0.08] flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="text-xs font-bold uppercase tracking-wider px-2 py-0.5 rounded-full" :class="selectedNodeBadgeClass">
                {{ selectedNodeData.entityType }}
              </span>
              <span class="text-xs text-[#86868b] font-mono">ID: {{ selectedNodeData.id }}</span>
            </div>
            <button
              @click="clearSelection"
              class="w-7 h-7 rounded-full bg-black/[0.04] dark:bg-white/[0.06] hover:bg-black/[0.08] flex items-center justify-center text-[#86868b] hover:text-[#1d1d1f] transition cursor-pointer"
            >
              ✕
            </button>
          </div>

          <!-- Body Content -->
          <div class="p-4 overflow-y-auto flex-1 space-y-4 text-xs text-[#1d1d1f] dark:text-[#f5f5f7]">
            <!-- Entity Profile Card -->
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-black/[0.02] dark:bg-white/[0.03] border border-black/[0.04] dark:border-white/[0.06]">
              <img
                v-if="selectedNodeData.avatar"
                :src="selectedNodeData.avatar"
                class="w-11 h-11 rounded-xl object-cover border border-black/[0.08] shadow-xs shrink-0"
              />
              <div v-else class="w-11 h-11 rounded-xl bg-[#0071e3]/10 text-[#0071e3] flex items-center justify-center text-xl shrink-0">
                {{ selectedNodeData.icon || '🏢' }}
              </div>
              <div class="min-w-0">
                <h3 class="font-bold text-xs tracking-tight truncate leading-tight">{{ selectedNodeData.name }}</h3>
                <p class="text-[10.5px] text-[#86868b] truncate mt-0.5">{{ selectedNodeData.subtitle || selectedNodeData.sector }}</p>
                <div v-if="selectedNodeData.major" class="mt-1">
                  <span class="text-[8.5px] font-bold px-1.5 py-0.2 rounded" :class="getMajorBadgeClass(selectedNodeData.major)">
                    {{ selectedNodeData.major }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Detail Properties Key-Value Table -->
            <div class="space-y-1.5">
              <span class="text-[9.5px] font-bold text-[#86868b] uppercase tracking-wider block">Atribut Entitas</span>
              <div class="bg-black/[0.02] dark:bg-white/[0.03] rounded-2xl p-2.5 border border-black/[0.04] dark:border-white/[0.06] space-y-2">
                <div v-for="prop in selectedNodeData.properties" :key="prop.label" class="flex items-center justify-between text-xs">
                  <span class="text-[#86868b] text-[11px]">{{ prop.label }}</span>
                  <span class="font-semibold text-right truncate ml-2 font-mono text-[11px]">{{ prop.value }}</span>
                </div>
              </div>
            </div>

            <!-- Upstream & Downstream Connected Entities -->
            <div class="space-y-1.5">
              <span class="text-[9.5px] font-bold text-[#86868b] uppercase tracking-wider block">Jalur Hubungan</span>
              <div class="space-y-1.5">
                <div
                  v-for="rel in selectedNodeData.relations"
                  :key="rel.id"
                  @click="selectNode(rel.type, rel.id)"
                  class="p-2 rounded-xl bg-black/[0.02] hover:bg-[#0071e3]/5 border border-black/[0.04] hover:border-[#0071e3]/30 transition flex items-center justify-between cursor-pointer apple-press"
                >
                  <div class="flex items-center gap-1.5 min-w-0">
                    <span class="material-symbols-outlined text-[15px] text-[#0071e3] shrink-0">arrow_right_alt</span>
                    <div class="min-w-0 truncate">
                      <div class="font-semibold text-[11px] leading-tight truncate">{{ rel.name }}</div>
                      <div class="text-[9px] text-[#86868b] truncate">{{ rel.relationType }}</div>
                    </div>
                  </div>
                  <span class="text-[8.5px] font-bold px-1.5 py-0.5 rounded bg-black/[0.05] dark:bg-white/[0.06] shrink-0">Lihat</span>
                </div>
              </div>
            </div>

            <!-- Quick WhatsApp Action -->
            <div v-if="selectedNodeData.phone" class="pt-1">
              <a
                :href="`https://wa.me/${selectedNodeData.phone.replace(/[^0-9]/g, '')}`"
                target="_blank"
                class="w-full py-2 px-3 rounded-xl bg-[#25D366] hover:bg-[#20ba59] text-white font-semibold text-xs flex items-center justify-center gap-1.5 shadow-xs transition apple-press cursor-pointer"
              >
                <span>💬 WhatsApp ({{ selectedNodeData.phone }})</span>
              </a>
            </div>
          </div>
        </div>
      </Transition>

      <!-- 4. FLOATING CANVAS CONTROLS DOCK (Bottom-Right, Ergonomic) -->
      <div
        class="absolute bottom-5 flex items-center bg-white/95 dark:bg-[#1c1c1f]/95 backdrop-blur-2xl border border-black/[0.08] dark:border-white/[0.1] rounded-2xl shadow-[0_8px_24px_rgba(0,0,0,0.1)] p-1 gap-1 z-30 transition-all duration-300"
        :class="selectedNodeData ? 'right-[380px]' : 'right-5'"
      >
        <button
          type="button"
          @click="zoomOut"
          class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-black/[0.05] dark:hover:bg-white/[0.08] text-[#1d1d1f] dark:text-[#f5f5f7] transition apple-press cursor-pointer"
          title="Zoom Out (-)"
        >
          <span class="material-symbols-outlined text-[16px]">remove</span>
        </button>
        <span
          @click="resetView"
          class="text-[11px] font-mono font-bold px-1.5 text-[#1d1d1f] dark:text-[#f5f5f7] min-w-[38px] text-center cursor-pointer hover:text-[#0071e3] transition-colors"
          title="Reset ke 100%"
        >
          {{ Math.round(zoomScale * 100) }}%
        </span>
        <button
          type="button"
          @click="zoomIn"
          class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-black/[0.05] dark:hover:bg-white/[0.08] text-[#1d1d1f] dark:text-[#f5f5f7] transition apple-press cursor-pointer"
          title="Zoom In (+)"
        >
          <span class="material-symbols-outlined text-[16px]">add</span>
        </button>

        <div class="w-[1px] h-4 bg-black/[0.08] dark:bg-white/[0.1] mx-0.5"></div>

        <button
          type="button"
          @click="fitView"
          class="px-2 h-7 flex items-center gap-1 rounded-lg hover:bg-black/[0.05] dark:hover:bg-white/[0.08] text-[#0071e3] font-semibold text-[11px] transition apple-press cursor-pointer"
          title="Sesuaikan Diagram Pas Layar"
        >
          <span class="material-symbols-outlined text-[15px]">fit_screen</span>
          <span>Pas Layar</span>
        </button>

        <div class="w-[1px] h-4 bg-black/[0.08] dark:bg-white/[0.1] mx-0.5"></div>

        <button
          type="button"
          @click="isPulseAnimationActive = !isPulseAnimationActive"
          :class="isPulseAnimationActive ? 'text-[#0071e3]' : 'text-[#86868b]'"
          class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-black/[0.05] dark:hover:bg-white/[0.08] transition apple-press cursor-pointer"
          :title="isPulseAnimationActive ? 'Matikan Animasi Aliran' : 'Aktifkan Animasi Aliran'"
        >
          <span class="material-symbols-outlined text-[16px]">motion_photos_on</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const {
  activeMenu,
  showToast,
  currentUser,
  openSettings,
  isSidebarCollapsed,
  toggleSidebarCollapse
} = useAppStore()

// State Canvas View
const activeDiagramMode = ref<'pipeline' | 'erd'>('pipeline')
const zoomScale = ref<number>(0.92)
const panX = ref<number>(20)
const panY = ref<number>(10)
const isDragging = ref<boolean>(false)
const dragStart = ref<{ x: number; y: number }>({ x: 0, y: 0 })
const canvasContainerRef = ref<HTMLElement | null>(null)

// Toggles & Filters
const selectedMajorFilter = ref<string>('all')
const searchQuery = ref<string>('')
const isPulseAnimationActive = ref<boolean>(true)

// Selected Node
const selectedNodeKey = ref<string | null>(null)
const selectedErdTable = ref<string | null>('users')

function switchDiagramMode(mode: 'pipeline' | 'erd') {
  activeDiagramMode.value = mode
  selectedNodeKey.value = null
  setTimeout(fitView, 50)
}

// -------------------------------------------------------------
// DATA PILAR SMKN 71 JAKARTA
// -------------------------------------------------------------
const guruList = ref([
  {
    id: 2,
    name: 'Dra. Nurul Hidayah, M.Pd',
    nip: '198502142010011002',
    email: 'guru@gmail.com',
    phone: '0812-0000-0002',
    roleBadge: 'Pembimbing Utama',
    avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150',
    assignedCompaniesCount: 3,
    assignedStudentsCount: 6,
    majors: ['PPLG', 'Animasi', 'DKV']
  },
  {
    id: 12,
    name: 'Bambang Irawan, S.Kom',
    nip: '198803152012011003',
    email: 'bambang.guru@gmail.com',
    phone: '0812-0000-0012',
    roleBadge: 'Koordinator PPLG',
    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150',
    assignedCompaniesCount: 1,
    assignedStudentsCount: 2,
    majors: ['PPLG']
  }
])

const companiesList = ref([
  {
    id: 1,
    name: 'PT Telkom Digital Solusi',
    icon: '💻',
    sector: 'Software & Cloud Platform',
    major: 'PPLG',
    address: 'Gedung Telkom Landmark Lt. 14, Jakarta Selatan',
    quota: 6,
    studentsCount: 2,
    workModes: 'WFO & WFH',
    teacherId: 2,
    mentorId: 3,
    color: '#0071e3'
  },
  {
    id: 2,
    name: 'Studio Animasi Kinetik',
    icon: '🎬',
    sector: '3D Animation & CGI Studio',
    major: 'Animasi',
    address: 'Jl. Raden Saleh No. 18, Cikini, Jakarta Pusat',
    quota: 4,
    studentsCount: 2,
    workModes: 'Hybrid',
    teacherId: 2,
    mentorId: 10,
    color: '#a855f7'
  },
  {
    id: 3,
    name: 'Pixel Kreatif Visual',
    icon: '🎨',
    sector: 'Brand Identity & UI/UX',
    major: 'DKV',
    address: 'Jl. Pemuda No. 65, Rawamangun, Jakarta Timur',
    quota: 5,
    studentsCount: 2,
    workModes: 'WFO & WFA',
    teacherId: 2,
    mentorId: 11,
    color: '#f59e0b'
  }
])

const mentorList = ref([
  {
    id: 3,
    name: 'Hendra Wijaya, S.Kom',
    companyId: 1,
    companyName: 'PT Telkom Digital Solusi',
    division: 'Lead Software Engineer',
    email: 'mentor@gmail.com',
    phone: '0812-0000-0003',
    studentsCount: 2,
    avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150',
    major: 'PPLG'
  },
  {
    id: 10,
    name: 'Raditya Pratama, S.Sn',
    companyId: 2,
    companyName: 'Studio Animasi Kinetik',
    division: 'Lead 3D Animator & Rigging',
    email: 'mentor2@gmail.com',
    phone: '0812-0000-0021',
    studentsCount: 2,
    avatar: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150',
    major: 'Animasi'
  },
  {
    id: 11,
    name: 'Maya Safitri, M.Ds',
    companyId: 3,
    companyName: 'Pixel Kreatif Visual',
    division: 'Creative Art Director',
    email: 'mentor3@gmail.com',
    phone: '0812-0000-0031',
    studentsCount: 2,
    avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150',
    major: 'DKV'
  }
])

const studentList = ref([
  {
    id: 4,
    name: 'Budi Santoso',
    nisn: '0061234567',
    major: 'PPLG',
    className: 'XII PPLG 1',
    workMode: 'WFO',
    email: 'siswa@gmail.com',
    phone: '0812-0000-0004',
    companyId: 1,
    mentorId: 3,
    teacherId: 2,
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150'
  },
  {
    id: 5,
    name: 'Siti Fauziah',
    nisn: '0061234568',
    major: 'PPLG',
    className: 'XII PPLG 2',
    workMode: 'WFH',
    email: 'siti@gmail.com',
    phone: '0812-0000-0005',
    companyId: 1,
    mentorId: 3,
    teacherId: 2,
    avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150'
  },
  {
    id: 6,
    name: 'Ahmad Danu',
    nisn: '0061234569',
    major: 'Animasi',
    className: 'XII Animasi 1',
    workMode: 'WFA',
    email: 'danu@gmail.com',
    phone: '0812-0000-0006',
    companyId: 2,
    mentorId: 10,
    teacherId: 2,
    avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150'
  },
  {
    id: 7,
    name: 'Putri Maharani',
    nisn: '0061234570',
    major: 'Animasi',
    className: 'XII Animasi 2',
    workMode: 'WFO',
    email: 'putri@gmail.com',
    phone: '0812-0000-0007',
    companyId: 2,
    mentorId: 10,
    teacherId: 2,
    avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150'
  },
  {
    id: 8,
    name: 'Rizky Pratama',
    nisn: '0061234571',
    major: 'DKV',
    className: 'XII DKV 1',
    workMode: 'WFO',
    email: 'rizky@gmail.com',
    phone: '0812-0000-0008',
    companyId: 3,
    mentorId: 11,
    teacherId: 2,
    avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150'
  },
  {
    id: 9,
    name: 'Jessica Tan',
    nisn: '0061234572',
    major: 'DKV',
    className: 'XII DKV 2',
    workMode: 'WFH',
    email: 'jessica@gmail.com',
    phone: '0812-0000-0009',
    companyId: 3,
    mentorId: 11,
    teacherId: 2,
    avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150'
  }
])

// -------------------------------------------------------------
// CONNECTION PATH GENERATION (Clean Structured Horizontal Flows)
// -------------------------------------------------------------
interface PipelineEdge {
  id: string
  fromType: 'guru' | 'company' | 'mentor'
  fromId: number
  toType: 'company' | 'mentor' | 'siswa'
  toId: number
  d: string
  color: string
  markerId: string
  isActive: boolean
}

const visiblePipelineEdges = computed<PipelineEdge[]>(() => {
  const edges: PipelineEdge[] = []

  // Geometric Column Anchor Coordinates:
  // Col 1 (Guru): x=40, w=240. Right Port at x=280px.
  // Col 2 (Company): x=360, w=250. Left Port at x=360px. Right Port at x=610px.
  // Col 3 (Mentor): x=690, w=240. Left Port at x=690px. Right Port at x=930px.
  // Col 4 (Student): x=1010, w=220. Left Port at x=1010px.
  const col1OutX = 280
  const col2InX = 360
  const col2OutX = 610
  const col3InX = 690
  const col3OutX = 930
  const col4InX = 1010

  // Anchor Y-Centers of Cards:
  // Guru: Dra Nurul (y=168), Bambang Irawan (y=428)
  const guruYMap: Record<number, number> = { 2: 168, 12: 428 }
  // Companies: Telkom (y=130), Kinetik (y=320), Pixel (y=510)
  const companyYMap: Record<number, number> = { 1: 130, 2: 320, 3: 510 }
  // Mentors: Hendra (y=130), Raditya (y=320), Maya (y=510)
  const mentorYMap: Record<number, number> = { 3: 130, 10: 320, 11: 510 }
  // Students:
  // Row 1: Budi (y=91), Siti (y=169)
  // Row 2: Danu (y=281), Putri (y=359)
  // Row 3: Rizky (y=471), Jessica (y=549)
  const studentYMap: Record<number, number> = {
    4: 91,
    5: 169,
    6: 281,
    7: 359,
    8: 471,
    9: 549
  }

  // 1. Edges: Guru ➔ Perusahaan
  companiesList.value.forEach(comp => {
    if (selectedMajorFilter.value !== 'all' && comp.major !== selectedMajorFilter.value) return

    const y1 = guruYMap[comp.teacherId] || 168
    const y2 = companyYMap[comp.id] || 130
    const x1 = col1OutX
    const x2 = col2InX
    const dx = x2 - x1
    const d = `M ${x1} ${y1} C ${x1 + dx * 0.5} ${y1}, ${x2 - dx * 0.5} ${y2}, ${x2} ${y2}`

    const isConnected = isEdgeHighlighted('guru', comp.teacherId, 'company', comp.id)
    edges.push({
      id: `edge-guru-${comp.teacherId}-comp-${comp.id}`,
      fromType: 'guru',
      fromId: comp.teacherId,
      toType: 'company',
      toId: comp.id,
      d,
      color: comp.color,
      markerId: comp.major === 'PPLG' ? 'arrow-pplg' : (comp.major === 'Animasi' ? 'arrow-animasi' : 'arrow-dkv'),
      isActive: isConnected
    })
  })

  // Edge from Guru 2 (Bambang Irawan) to PT Telkom
  if (selectedMajorFilter.value === 'all' || selectedMajorFilter.value === 'PPLG') {
    const y1 = guruYMap[12]
    const y2 = companyYMap[1]
    const x1 = col1OutX
    const x2 = col2InX
    const dx = x2 - x1
    const d = `M ${x1} ${y1} C ${x1 + dx * 0.5} ${y1}, ${x2 - dx * 0.5} ${y2}, ${x2} ${y2}`
    const isConnected = isEdgeHighlighted('guru', 12, 'company', 1)
    edges.push({
      id: `edge-guru-12-comp-1`,
      fromType: 'guru',
      fromId: 12,
      toType: 'company',
      toId: 1,
      d,
      color: '#0071e3',
      markerId: 'arrow-pplg',
      isActive: isConnected
    })
  }

  // 2. Edges: Perusahaan ➔ Mentor (Direct Horizontal Alignment)
  mentorList.value.forEach(mentor => {
    if (selectedMajorFilter.value !== 'all' && mentor.major !== selectedMajorFilter.value) return

    const y1 = companyYMap[mentor.companyId] || 130
    const y2 = mentorYMap[mentor.id] || 130
    const x1 = col2OutX
    const x2 = col3InX
    const dx = x2 - x1
    const d = `M ${x1} ${y1} C ${x1 + dx * 0.5} ${y1}, ${x2 - dx * 0.5} ${y2}, ${x2} ${y2}`

    const isConnected = isEdgeHighlighted('company', mentor.companyId, 'mentor', mentor.id)
    const comp = companiesList.value.find(c => c.id === mentor.companyId)
    const color = comp ? comp.color : '#0071e3'

    edges.push({
      id: `edge-comp-${mentor.companyId}-mentor-${mentor.id}`,
      fromType: 'company',
      fromId: mentor.companyId,
      toType: 'mentor',
      toId: mentor.id,
      d,
      color,
      markerId: mentor.major === 'PPLG' ? 'arrow-pplg' : (mentor.major === 'Animasi' ? 'arrow-animasi' : 'arrow-dkv'),
      isActive: isConnected
    })
  })

  // 3. Edges: Mentor ➔ Siswa (Clean Symmetrical Fork to Student Cards)
  studentList.value.forEach(siswa => {
    if (selectedMajorFilter.value !== 'all' && siswa.major !== selectedMajorFilter.value) return

    const y1 = mentorYMap[siswa.mentorId] || 130
    const y2 = studentYMap[siswa.id] || 91
    const x1 = col3OutX
    const x2 = col4InX
    const dx = x2 - x1
    const d = `M ${x1} ${y1} C ${x1 + dx * 0.5} ${y1}, ${x2 - dx * 0.5} ${y2}, ${x2} ${y2}`

    const isConnected = isEdgeHighlighted('mentor', siswa.mentorId, 'siswa', siswa.id)
    const color = siswa.major === 'PPLG' ? '#0071e3' : (siswa.major === 'Animasi' ? '#a855f7' : '#f59e0b')

    edges.push({
      id: `edge-mentor-${siswa.mentorId}-siswa-${siswa.id}`,
      fromType: 'mentor',
      fromId: siswa.mentorId,
      toType: 'siswa',
      toId: siswa.id,
      d,
      color,
      markerId: siswa.major === 'PPLG' ? 'arrow-pplg' : (siswa.major === 'Animasi' ? 'arrow-animasi' : 'arrow-dkv'),
      isActive: isConnected
    })
  })

  return edges
})

function isEdgeHighlighted(fromType: string, fromId: number, toType: string, toId: number): boolean {
  if (!selectedNodeKey.value) return true

  const [selType, selIdStr] = selectedNodeKey.value.split('-')
  const selId = parseInt(selIdStr)

  if (selType === 'guru') {
    if (fromType === 'guru' && fromId === selId) return true
    if (fromType === 'company') {
      const comp = companiesList.value.find(c => c.id === fromId)
      return comp?.teacherId === selId || (selId === 12 && fromId === 1)
    }
    if (fromType === 'mentor') {
      const student = studentList.value.find(s => s.mentorId === fromId && (s.teacherId === selId || selId === 12))
      return !!student
    }
  } else if (selType === 'company') {
    if (fromType === 'guru' && toId === selId) return true
    if (fromType === 'company' && fromId === selId) return true
    if (fromType === 'mentor') {
      const mentor = mentorList.value.find(m => m.id === fromId)
      return mentor?.companyId === selId
    }
  } else if (selType === 'mentor') {
    const mentor = mentorList.value.find(m => m.id === selId)
    if (!mentor) return false
    if (fromType === 'company' && fromId === mentor.companyId && toId === selId) return true
    if (fromType === 'guru') {
      const comp = companiesList.value.find(c => c.id === mentor.companyId)
      return comp?.teacherId === fromId
    }
    if (fromType === 'mentor' && fromId === selId) return true
  } else if (selType === 'siswa') {
    const student = studentList.value.find(s => s.id === selId)
    if (!student) return false
    if (toType === 'siswa' && toId === selId) return true
    if (fromType === 'company' && fromId === student.companyId && toId === student.mentorId) return true
    if (fromType === 'guru' && fromId === student.teacherId && toId === student.companyId) return true
  }

  return false
}

function selectNode(type: string, id: number) {
  const key = `${type}-${id}`
  if (selectedNodeKey.value === key) {
    selectedNodeKey.value = null
  } else {
    selectedNodeKey.value = key
  }
}

function clearSelection() {
  selectedNodeKey.value = null
}

function getNodeClasses(type: string, id: number): string {
  const key = `${type}-${id}`

  // Check Major Filter match
  if (selectedMajorFilter.value !== 'all') {
    let nodeMajor = ''
    if (type === 'guru') {
      const g = guruList.value.find(item => item.id === id)
      if (g && !g.majors.includes(selectedMajorFilter.value)) {
        return 'opacity-20 pointer-events-none border-black/[0.04] dark:border-white/[0.04]'
      }
    } else if (type === 'company') {
      const c = companiesList.value.find(item => item.id === id)
      if (c && c.major !== selectedMajorFilter.value) {
        return 'opacity-20 pointer-events-none border-black/[0.04] dark:border-white/[0.04]'
      }
    } else if (type === 'mentor') {
      const m = mentorList.value.find(item => item.id === id)
      if (m && m.major !== selectedMajorFilter.value) {
        return 'opacity-20 pointer-events-none border-black/[0.04] dark:border-white/[0.04]'
      }
    } else if (type === 'siswa') {
      const s = studentList.value.find(item => item.id === id)
      if (s && s.major !== selectedMajorFilter.value) {
        return 'opacity-20 pointer-events-none border-black/[0.04] dark:border-white/[0.04]'
      }
    }
  }

  // Check Search Query match
  if (searchQuery.value.trim() !== '') {
    const q = searchQuery.value.toLowerCase().trim()
    let isMatch = false
    if (type === 'guru') {
      const g = guruList.value.find(item => item.id === id)
      if (g && (g.name.toLowerCase().includes(q) || g.nip.includes(q))) isMatch = true
    } else if (type === 'company') {
      const c = companiesList.value.find(item => item.id === id)
      if (c && (c.name.toLowerCase().includes(q) || c.sector.toLowerCase().includes(q))) isMatch = true
    } else if (type === 'mentor') {
      const m = mentorList.value.find(item => item.id === id)
      if (m && (m.name.toLowerCase().includes(q) || m.division.toLowerCase().includes(q))) isMatch = true
    } else if (type === 'siswa') {
      const s = studentList.value.find(item => item.id === id)
      if (s && (s.name.toLowerCase().includes(q) || s.nisn.includes(q) || s.className.toLowerCase().includes(q))) isMatch = true
    }

    if (isMatch) {
      return 'ring-4 ring-[#0071e3] border-[#0071e3] shadow-lg scale-[1.02]'
    } else {
      return 'opacity-25 border-black/[0.04] dark:border-white/[0.04]'
    }
  }

  // If no node selected, normal crisp state
  if (!selectedNodeKey.value) {
    return 'border-black/[0.08] dark:border-white/[0.08] hover:border-[#0071e3]/50'
  }

  // Selected Node itself
  if (selectedNodeKey.value === key) {
    return 'ring-4 ring-[#0071e3]/30 border-[#0071e3] shadow-lg scale-[1.03]'
  }

  // Lineage Connected Nodes
  const [selType, selIdStr] = selectedNodeKey.value.split('-')
  const selId = parseInt(selIdStr)

  let isConnected = false
  if (selType === 'siswa') {
    const s = studentList.value.find(item => item.id === selId)
    if (s) {
      if (type === 'mentor' && id === s.mentorId) isConnected = true
      if (type === 'company' && id === s.companyId) isConnected = true
      if (type === 'guru' && id === s.teacherId) isConnected = true
    }
  } else if (selType === 'mentor') {
    const m = mentorList.value.find(item => item.id === selId)
    if (m) {
      if (type === 'company' && id === m.companyId) isConnected = true
      if (type === 'siswa' && studentList.value.some(s => s.mentorId === selId && s.id === id)) isConnected = true
      const comp = companiesList.value.find(c => c.id === m.companyId)
      if (type === 'guru' && comp?.teacherId === id) isConnected = true
    }
  } else if (selType === 'company') {
    const c = companiesList.value.find(item => item.id === selId)
    if (c) {
      if (type === 'guru' && (id === c.teacherId || (c.id === 1 && id === 12))) isConnected = true
      if (type === 'mentor' && id === c.mentorId) isConnected = true
      if (type === 'siswa' && studentList.value.some(s => s.companyId === selId && s.id === id)) isConnected = true
    }
  } else if (selType === 'guru') {
    if (selId === 2) {
      if (type === 'company' && companiesList.value.some(c => c.teacherId === selId && c.id === id)) isConnected = true
      if (type === 'mentor' && companiesList.value.some(c => c.teacherId === selId && c.mentorId === id)) isConnected = true
      if (type === 'siswa' && studentList.value.some(s => s.teacherId === selId && s.id === id)) isConnected = true
    } else if (selId === 12) {
      if (type === 'company' && id === 1) isConnected = true
      if (type === 'mentor' && id === 3) isConnected = true
      if (type === 'siswa' && (id === 4 || id === 5)) isConnected = true
    }
  }

  if (isConnected) {
    return 'border-[#0071e3]/80 ring-3 ring-[#0071e3]/20 shadow-md scale-[1.01]'
  }

  return 'opacity-25 border-black/[0.04] dark:border-white/[0.04]'
}

// -------------------------------------------------------------
// DETAIL INSPECTOR COMPUTED DATA
// -------------------------------------------------------------
const selectedNodeData = computed(() => {
  if (!selectedNodeKey.value) return null
  const [type, idStr] = selectedNodeKey.value.split('-')
  const id = parseInt(idStr)

  if (type === 'guru') {
    const guru = guruList.value.find(g => g.id === id)
    if (!guru) return null
    return {
      id: guru.id,
      entityType: 'Guru Pembimbing',
      name: guru.name,
      subtitle: guru.roleBadge,
      avatar: guru.avatar,
      email: guru.email,
      phone: guru.phone,
      properties: [
        { label: 'NIP Pegawai', value: guru.nip },
        { label: 'Email Resmi', value: guru.email },
        { label: 'No. WhatsApp', value: guru.phone },
        { label: 'Jurusan Binaan', value: guru.majors.join(', ') },
        { label: 'Mitra DUDI', value: `${guru.assignedCompaniesCount} Industri` },
        { label: 'Siswa PKL', value: `${guru.assignedStudentsCount} Siswa Binaan` },
      ],
      relations: companiesList.value.filter(c => c.teacherId === guru.id || (guru.id === 12 && c.id === 1)).map(c => ({
        id: c.id,
        type: 'company',
        name: c.name,
        relationType: `Mitra PKL (${c.major})`
      }))
    }
  }

  if (type === 'company') {
    const comp = companiesList.value.find(c => c.id === id)
    if (!comp) return null
    const mentor = mentorList.value.find(m => m.id === comp.mentorId)
    const guru = guruList.value.find(g => g.id === comp.teacherId)
    return {
      id: comp.id,
      entityType: 'Mitra Tempat PKL',
      name: comp.name,
      icon: comp.icon,
      sector: comp.sector,
      major: comp.major,
      properties: [
        { label: 'Sektor', value: comp.sector },
        { label: 'Jurusan', value: comp.major },
        { label: 'Alamat', value: comp.address },
        { label: 'Kuota', value: `${comp.quota} Kursi (${comp.studentsCount} Terisi)` },
        { label: 'Mode Kerja', value: comp.workModes },
        { label: 'Geofence', value: '150 Meter' },
      ],
      relations: [
        ...(guru ? [{ id: guru.id, type: 'guru', name: guru.name, relationType: 'Guru Supervisi' }] : []),
        ...(mentor ? [{ id: mentor.id, type: 'mentor', name: mentor.name, relationType: 'Pembimbing Lapangan' }] : []),
        ...studentList.value.filter(s => s.companyId === comp.id).map(s => ({
          id: s.id,
          type: 'siswa',
          name: `${s.name} (${s.className})`,
          relationType: 'Peserta PKL'
        }))
      ]
    }
  }

  if (type === 'mentor') {
    const mentor = mentorList.value.find(m => m.id === id)
    if (!mentor) return null
    return {
      id: mentor.id,
      entityType: 'Pembimbing Lapangan',
      name: mentor.name,
      subtitle: mentor.division,
      avatar: mentor.avatar,
      major: mentor.major,
      phone: mentor.phone,
      properties: [
        { label: 'Perusahaan', value: mentor.companyName },
        { label: 'Jabatan', value: mentor.division },
        { label: 'No. WA', value: mentor.phone },
        { label: 'Email', value: mentor.email },
        { label: 'Binaan', value: `${mentor.studentsCount} Siswa` },
      ],
      relations: [
        { id: mentor.companyId, type: 'company', name: mentor.companyName, relationType: 'Perusahaan' },
        ...studentList.value.filter(s => s.mentorId === mentor.id).map(s => ({
          id: s.id,
          type: 'siswa',
          name: `${s.name} (${s.className})`,
          relationType: `Siswa (${s.workMode})`
        }))
      ]
    }
  }

  if (type === 'siswa') {
    const s = studentList.value.find(item => item.id === id)
    if (!s) return null
    const comp = companiesList.value.find(c => c.id === s.companyId)
    const mentor = mentorList.value.find(m => m.id === s.mentorId)
    const guru = guruList.value.find(g => g.id === s.teacherId)
    return {
      id: s.id,
      entityType: 'Siswa Peserta PKL',
      name: s.name,
      subtitle: `${s.className} • NISN ${s.nisn}`,
      avatar: s.avatar,
      major: s.major,
      phone: s.phone,
      properties: [
        { label: 'NISN', value: s.nisn },
        { label: 'Kelas', value: `${s.className} (${s.major})` },
        { label: 'Mode Kerja', value: s.workMode },
        { label: 'Tempat PKL', value: comp?.name || '-' },
        { label: 'Mentor', value: mentor?.name || '-' },
        { label: 'Guru', value: guru?.name || '-' },
      ],
      relations: [
        ...(comp ? [{ id: comp.id, type: 'company', name: comp.name, relationType: 'Tempat PKL' }] : []),
        ...(mentor ? [{ id: mentor.id, type: 'mentor', name: mentor.name, relationType: 'Mentor' }] : []),
        ...(guru ? [{ id: guru.id, type: 'guru', name: guru.name, relationType: 'Guru' }] : [])
      ]
    }
  }

  return null
})

const selectedNodeBadgeClass = computed(() => {
  if (!selectedNodeData.value) return ''
  const t = selectedNodeData.value.entityType
  if (t.includes('Guru')) return 'bg-emerald-500/10 text-emerald-600'
  if (t.includes('Tempat') || t.includes('Mitra')) return 'bg-blue-500/10 text-blue-600'
  if (t.includes('Pembimbing')) return 'bg-indigo-500/10 text-indigo-600'
  return 'bg-amber-500/10 text-amber-600'
})

function getMajorBadgeClass(major: string): string {
  if (major === 'PPLG') return 'bg-blue-500/10 text-blue-600 dark:text-blue-400'
  if (major === 'Animasi') return 'bg-purple-500/10 text-purple-600 dark:text-purple-400'
  if (major === 'DKV') return 'bg-amber-500/10 text-amber-600 dark:text-amber-400'
  return 'bg-black/[0.05] text-[#1d1d1f]'
}

function selectErdTable(tableName: string) {
  selectedErdTable.value = tableName
  showToast(`Melihat relasi skema tabel database: ${tableName}`, 'info')
}

// -------------------------------------------------------------
// PAN & ZOOM CANVAS GESTURES
// -------------------------------------------------------------
function startPan(e: MouseEvent) {
  if ((e.target as HTMLElement).closest('.node-card, button, select, input, a')) return
  isDragging.value = true
  dragStart.value = { x: e.clientX - panX.value, y: e.clientY - panY.value }
}

function handlePan(e: MouseEvent) {
  if (!isDragging.value) return
  panX.value = e.clientX - dragStart.value.x
  panY.value = e.clientY - dragStart.value.y
}

function stopPan() {
  isDragging.value = false
}

function handleWheelZoom(e: WheelEvent) {
  if (e.ctrlKey || e.metaKey) {
    const delta = -e.deltaY * 0.0015
    const newScale = Math.min(1.6, Math.max(0.4, zoomScale.value + delta))
    zoomScale.value = Number(newScale.toFixed(2))
  } else {
    panX.value -= e.deltaX * 0.8
    panY.value -= e.deltaY * 0.8
  }
}

function zoomIn() {
  zoomScale.value = Math.min(1.6, Number((zoomScale.value + 0.1).toFixed(2)))
}

function zoomOut() {
  zoomScale.value = Math.max(0.4, Number((zoomScale.value - 0.1).toFixed(2)))
}

function resetView() {
  zoomScale.value = 1.0
  panX.value = 20
  panY.value = 10
  selectedNodeKey.value = null
  showToast('Kanvas skala 100% (Ukuran Asli)', 'info')
}

function fitView() {
  if (!canvasContainerRef.value) return
  const containerW = canvasContainerRef.value.clientWidth
  const containerH = canvasContainerRef.value.clientHeight
  const targetW = activeDiagramMode.value === 'pipeline' ? 1280 : 1340
  const targetH = activeDiagramMode.value === 'pipeline' ? 650 : 700

  if (containerW <= 0 || containerH <= 0) return

  const scaleW = (containerW - 40) / targetW
  const scaleH = (containerH - 40) / targetH
  const idealScale = Math.min(1.0, Math.max(0.48, Math.min(scaleW, scaleH)))

  zoomScale.value = Number(idealScale.toFixed(2))
  // Center horizontally in container
  const scaledW = targetW * zoomScale.value
  panX.value = Math.max(10, Math.round((containerW - scaledW) / 2))
  panY.value = 15
}

// Watch sidebar collapse to auto recalculate canvas size
watch(isSidebarCollapsed, () => {
  setTimeout(() => {
    fitView()
  }, 320)
})

onMounted(() => {
  fitView()
  window.addEventListener('resize', fitView)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', fitView)
})
</script>

<style scoped>
/* Animated Dash Flow Along Bezier Connectors */
@keyframes dash-flow {
  from {
    stroke-dashoffset: 20;
  }
  to {
    stroke-dashoffset: 0;
  }
}

.animate-flow-dash {
  animation: dash-flow 0.9s linear infinite;
}
</style>
