<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0">
  <!-- SIDEBAR HEADER -->
  <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center gap-2 pt-8 sidebar-header pb-7">
    <a href="{{ route('dashboard') }}">
      <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Event System</h2>
      </span>

      <span class="logo-icon text-2xl" :class="sidebarToggle ? 'lg:block' : 'hidden'">
        📅
      </span>
    </a>
  </div>
  <!-- SIDEBAR HEADER -->

  <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
    <!-- Sidebar Menu -->
    <nav x-data="{selected: $persist('Dashboard')}">
      <!-- Menu Group -->
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
            MENU
          </span>

          <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'" class="mx-auto fill-current menu-group-icon"
            width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
              fill="" />
          </svg>
        </h3>

        <ul class="flex flex-col gap-4 mb-6">
          <!-- Dashboard -->
          <li>
            <a href="{{ route('dashboard') }}" @click="selected = 'Dashboard'" class="menu-item group"
              :class="selected === 'Dashboard' ? 'menu-item-active' : 'menu-item-inactive'">
              <svg :class="selected === 'Dashboard' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24"
                height="24" viewBox="0 0 24 24" fill="none">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" fill="" />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Dashboard</span>
            </a>
          </li>

          @can('manage_organizations')
            <!-- Organisasi -->
            <li>
              <a href="{{ auth()->user()->isSuperAdmin() ? route('super.organizations.index') : route('admin.organizations.index') }}"
                @click="selected = 'Organisasi'" class="menu-item group"
                :class="selected === 'Organisasi' ? 'menu-item-active' : 'menu-item-inactive'">
                <svg :class="selected === 'Organisasi' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24"
                  height="24" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"
                    fill="" />
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Organisasi</span>
              </a>
            </li>
          @endcan

          @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin'))
            <!-- Users -->
            <li>
              <a href="{{ auth()->user()->hasRole('super-admin') ? route('super.users.index') : route('admin.users.index') }}"
                @click="selected = 'Users'" class="menu-item group"
                :class="selected === 'Users' ? 'menu-item-active' : 'menu-item-inactive'">
                <svg :class="selected === 'Users' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24"
                  height="24" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"
                    fill="" />
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Users</span>
              </a>
            </li>
          @endif

          @can('manage_events')
            <!-- Event -->
            <li>
              <a href="{{ auth()->user()->isSuperAdmin() ? route('super.events.pending') : (auth()->user()->isAdmin() ? route('admin.events.index') : route('user.events.index')) }}"
                @click="selected = 'Event'" class="menu-item group"
                :class="selected === 'Event' ? 'menu-item-active' : 'menu-item-inactive'">
                <svg :class="selected === 'Event' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24"
                  height="24" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-8 4H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z"
                    fill="" />
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Event</span>
              </a>
            </li>
          @elsecan('view_events')
            <!-- Event (View Only) -->
            <li>
              <a href="{{ route('user.events.index') }}" @click="selected = 'Event'" class="menu-item group"
                :class="selected === 'Event' ? 'menu-item-active' : 'menu-item-inactive'">
                <svg :class="selected === 'Event' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24"
                  height="24" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-8 4H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z"
                    fill="" />
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Event</span>
              </a>
            </li>
          @endcan

          @can('manage_certificates')
            <!-- Sertifikat -->
            <li>
              <a href="{{ auth()->user()->isSuperAdmin() ? route('super.certificates.index') : (auth()->user()->isAdmin() ? route('admin.certificates.index') : route('user.certificates.index')) }}"
                @click="selected = 'Sertifikat'" class="menu-item group"
                :class="selected === 'Sertifikat' ? 'menu-item-active' : 'menu-item-inactive'">
                <svg :class="selected === 'Sertifikat' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24"
                  height="24" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H8V4h12v12zM10 9h8v2h-8zm0 3h4v2h-4zm0-6h8v2h-8z"
                    fill="" />
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Sertifikat</span>
              </a>
            </li>
          @elsecan('view_certificates')
            <!-- Sertifikat (View Only) -->
            <li>
              <a href="{{ route('user.certificates.index') }}" @click="selected = 'Sertifikat'" class="menu-item group"
                :class="selected === 'Sertifikat' ? 'menu-item-active' : 'menu-item-inactive'">
                <svg :class="selected === 'Sertifikat' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24"
                  height="24" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H8V4h12v12zM10 9h8v2h-8zm0 3h4v2h-4zm0-6h8v2h-8z"
                    fill="" />
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Sertifikat</span>
              </a>
            </li>
          @endcan

          @can('manage_registrations')
            <!-- Daftar Ulang -->
            <li>
              <a href="{{ auth()->user()->isSuperAdmin() ? route('super.registrations.index') : (auth()->user()->isAdmin() ? route('admin.registrations.index') : route('user.registrations.index')) }}"
                @click="selected = 'Daftar Ulang'" class="menu-item group"
                :class="selected === 'Daftar Ulang' ? 'menu-item-active' : 'menu-item-inactive'">
                <svg :class="selected === 'Daftar Ulang' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24"
                  height="24" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"
                    fill="" />
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Daftar Ulang</span>
              </a>
            </li>
          @endcan
        </ul>
      </div>

      <!-- Others Group (Super Admin Only) -->
      @can('manage_roles')
        <div>
          <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
            <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
              ADMIN
            </span>
          </h3>

          <ul class="flex flex-col gap-4 mb-6">


            <!-- Role Management -->
            <li>
              <a href="#" @click="selected = 'Roles'" class="menu-item group"
                :class="selected === 'Roles' ? 'menu-item-active' : 'menu-item-inactive'">
                <svg :class="selected === 'Roles' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24"
                  height="24" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"
                    fill="" />
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Roles</span>
              </a>
            </li>
          </ul>
        </div>
      @endcan

      <!-- Logout -->
      <div class="mt-auto pt-6 border-t border-gray-200 dark:border-gray-800">
        <ul class="flex flex-col gap-4 mb-6">
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit"
                class="menu-item group w-full text-left menu-item-inactive hover:bg-red-50 dark:hover:bg-red-900/20">
                <svg class="menu-item-icon-inactive" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"
                    fill="" />
                </svg>
                <span class="menu-item-text text-red-600 dark:text-red-400"
                  :class="sidebarToggle ? 'lg:hidden' : ''">Logout</span>
              </button>
            </form>
          </li>
        </ul>
      </div>
    </nav>
    <!-- Sidebar Menu -->

  </div>
</aside>